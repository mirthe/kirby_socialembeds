<?php 
    require_once __DIR__ . '/classes/Bluesky.php';
    require_once __DIR__ . '/classes/Instagram.php';
    require_once __DIR__ . '/classes/Pixelfed.php';
    require_once __DIR__ . '/classes/Mastodon.php';
    require_once __DIR__ . '/classes/Twitter.php';

    Kirby::plugin('mirthe/social-embeds', [
    
    'options' => [
        'cache'    => true,
        'maxwidth' => 600,
        'colorMode' => 'system',
    ],

    'tags' => [
        'bluesky' => [
            'attr' => ['url'],
            'html' => fn($tag) => SocialEmbedsBluesky::embed($tag->url),
        ],

        'instagram' => [
            'attr' => ['id'],
            'html' => fn($tag) => SocialEmbedsInstagram::embed($tag->id),
        ],

        'pixelfed' => [
            'attr' => ['url'],
            'html' => fn($tag) => SocialEmbedsPixelfed::embed($tag->url),
        ],

        'mastodon' => [
            'attr' => ['url'],
            'html' => fn($tag) => SocialEmbedsMastodon::embed($tag->url),
        ],

        'tweet' => [
            'attr' => ['url'],
            'html' => fn($tag) => SocialEmbedsTwitter::embed($tag->url),
        ],
    ]
]);