<?php

class SocialEmbedsTwitter
{
    public static function embed(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        $html  = '<blockquote class="twitter-tweet">';
        $html .= '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"></a>';
        $html .= '</blockquote>';
        $html .= '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';

        return $html;
    }
}