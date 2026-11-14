<?php

use App\Models\SiteSetting;

if (! function_exists('setting')) {
    /**
     * Get a site setting by key with an optional fallback default.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }
}

if (! function_exists('format_hero_headline')) {
    /**
     * Format hero headline text, converting [bracketed text] into styled terracotta underline span.
     *
     * @param string|null $headline
     * @return string
     */
    function format_hero_headline(?string $headline): string
    {
        if (empty($headline)) {
            $headline = 'Not just a holiday, but a journey that [lingers in your soul.]';
        }

        return preg_replace(
            '/\[(.*?)\]/',
            '<span class="italic underline decoration-[#c86d51] decoration-4 underline-offset-8">$1</span>',
            $headline
        );
    }
}
