<?php

class SocialEmbedsPixelfed
{
    /**
     * Genereer de embedcode voor een Pixelfed-post.
     */
    public static function embed(string $url): string
    {
        $parts = parse_url($url);

        // Controleer de URL
        if (
            empty($parts['scheme']) ||
            $parts['scheme'] !== 'https' ||
            empty($parts['host']) ||
            empty($parts['path']) ||
            !empty($parts['user']) ||
            !empty($parts['pass']) ||
            !empty($parts['port']) ||
            !empty($parts['query']) ||
            !empty($parts['fragment']) ||
            !preg_match(
                '~^/p/[a-zA-Z0-9_]+/[0-9]+/?$~',
                $parts['path']
            )
        ) {
            return '';
        }

        $host = strtolower($parts['host']);

        // Bouw de embed-URL op
        $baseUrl = 'https://' . $host . rtrim($parts['path'], '/');

        $embedUrl = $baseUrl . '/embed?' . http_build_query([
            'caption' => 'true',
            'likes'   => 'false',
            'layout'  => 'full',
        ]);

        // Embed-script
        $scriptUrl = 'https://' . $host . '/embed.js';

        return sprintf(
            '<iframe src="%s" class="pixelfed__embed" style="max-width:100%%; border:0" width="600" allowfullscreen></iframe><script async defer src="%s"></script>',
            htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($scriptUrl, ENT_QUOTES, 'UTF-8')
        );
    }
}
