<?php

class SocialEmbedsBluesky
{
    /**
     * Haal een Bluesky-post op en retourneer de embedcode.
     */
    public static function embed(string $url): string
    {
        // Controleer de URL
        if (!preg_match(
            '~^https://bsky\.app/profile/[^/]+/post/[a-zA-Z0-9]+/?$~',
            $url
        )) {
            return '';
        }

        // Opties
        $maxwidth = option('mirthe.social-embeds.maxwidth', 600);

        $colorMode = option(
            'mirthe.social-embeds.colorMode',
            'system'
        );

        if (!in_array($colorMode, ['system', 'light', 'dark'], true)) {
            $colorMode = 'system';
        }

        // Cache
        $cache = kirby()->cache('mirthe.social-embeds');
        $cacheKey = md5($url . $maxwidth . $colorMode);

        if (option('mirthe.social-embeds.cache', true)) {
            $cached = $cache->get($cacheKey);

            if ($cached !== null) {
                return $cached;
            }
        }

        // oEmbed endpoint
        $endpoint = 'https://embed.bsky.app/oembed?' .
            http_build_query([
                'url'      => $url,
                'maxwidth' => $maxwidth,
            ]);

        try {
            $response = Remote::get($endpoint, [
                'timeout' => 10,
            ]);

            if ($response->code() !== 200) {
                return '';
            }

            $data = $response->json();

            if (empty($data['html'])) {
                return '';
            }

            // Stel de kleurmodus in
            $html = preg_replace(
                '/<blockquote\b/',
                '<blockquote data-bluesky-embed-color-mode="' .
                    $colorMode . '"',
                $data['html'],
                1
            );

            // Bewaar de embedcode 24 uur
            if (option('mirthe.social-embeds.cache', true)) {
                $cache->set($cacheKey, $html, 1440);
            }

            return $html;

        } catch (Throwable $e) {
            return '';
        }
    }
}
