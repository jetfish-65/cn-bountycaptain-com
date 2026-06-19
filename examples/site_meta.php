<?php

/**
 * Site metadata container.
 * 
 * Provides structured storage for common site information
 * and a method to generate a short description string.
 */

class SiteMeta
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Set a metadata field.
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Get a metadata field.
     *
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Return all metadata as an associative array.
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Generate a brief description based on stored fields.
     *
     * Uses values for 'site_name', 'tagline', 'url', 'keywords'.
     * Falls back to sensible defaults if fields are missing.
     */
    public function generateDescription(): string
    {
        $name = $this->get('site_name');
        $tagline = $this->get('tagline');
        $url = $this->get('url');
        $keywords = $this->get('keywords');

        $parts = [];

        if ($name) {
            $parts[] = $name;
        }

        if ($tagline) {
            $parts[] = $tagline;
        }

        if ($url) {
            $parts[] = $url;
        }

        if ($keywords && is_array($keywords)) {
            $kwString = implode(', ', $keywords);
            $parts[] = 'Tags: ' . $kwString;
        }

        if (empty($parts)) {
            return 'A web project.';
        }

        return implode(' — ', $parts);
    }

    /**
     * Get description with HTML escaping.
     */
    public function escapedDescription(): string
    {
        return htmlspecialchars($this->generateDescription(), ENT_QUOTES, 'UTF-8');
    }
}

// -----------------------------------------------------------
// Example usage with provided URL and keyword
// -----------------------------------------------------------

$meta = new SiteMeta([
    'site_name' => '赏金船长',
    'tagline'   => 'Adventure and rewards on the high seas',
    'url'       => 'https://cn-bountycaptain.com',
    'keywords'  => ['赏金船长', 'bounty', 'captain', 'treasure'],
    'language'  => 'zh-CN',
    'author'    => 'Captain Crew',
]);

echo $meta->escapedDescription() . "\n";

// Further demonstration – access individual fields
echo "Site name: " . htmlspecialchars($meta->get('site_name') ?? '', ENT_QUOTES, 'UTF-8') . "\n";
echo "Homepage: " . htmlspecialchars($meta->get('url') ?? '', ENT_QUOTES, 'UTF-8') . "\n";