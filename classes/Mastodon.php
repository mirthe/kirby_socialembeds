<?php

class SocialEmbedsMastodon
{
    /**
     * Haal een Mastodon-post op en retourneer de embedcode.
     */
    public static function embed(string $url): string
    {
        // Controleer de URL
        $parts = parse_url($url);

        if (
            empty($parts['scheme']) ||
            $parts['scheme'] !== 'https' ||
            empty($parts['host']) ||
            !empty($parts['user']) ||
            !empty($parts['pass']) ||
            !empty($parts['port']) ||
            !empty($parts['query']) ||
            !empty($parts['fragment']) ||
            empty($parts['path']) ||
            !preg_match(
                '~^/@[^/]+/[0-9]+/?$~',
                $parts['path']
            )
        ) {
            return '';
        }

        $host = strtolower($parts['host']);

        // Cache
        $cache = kirby()->cache('mirthe.social-embeds');
        $maxwidth = option('mirthe.social-embeds.maxwidth', 600);
        $cacheKey = md5($url . $maxwidth);

        if (option('mirthe.social-embeds.cache', true)) {
            $cached = $cache->get($cacheKey);

            if ($cached !== null) {
                return $cached;
            }
        }

        // oEmbed endpoint van de betreffende instance
        $endpoint = 'https://' . $host . '/api/oembed?' .
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

            $html = $data['html'];

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
