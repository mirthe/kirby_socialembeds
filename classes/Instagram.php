<?php

class SocialEmbedsInstagram
{
    public static function embed(string $id): string
    {
        // Alleen geldige Instagram-post-ID's toestaan
        if (!preg_match('/^[A-Za-z0-9_-]+$/', $id)) {
            return '';
        }

        $url = 'https://www.instagram.com/p/' . $id . '/';

        $html  = '<blockquote class="instagram-media"';
        $html .= ' data-instgrm-captioned';
        $html .= ' data-instgrm-permalink="' . $url . '?utm_source=ig_embed&amp;utm_campaign=loading"';
        $html .= ' data-instgrm-version="14">';
        $html .= '<a href="' . $url . '" target="_blank" rel="noopener">';
        $html .= 'View this post on Instagram';
        $html .= '</a>';
        $html .= '</blockquote>';
        $html .= '<script async src="https://www.instagram.com/embed.js"></script>';

        return $html;
    }
}