# Kirby Social Embeds

A Kirby CMS plugin to embed social media posts in your content.

Supports embedding posts from Bluesky, Pixelfed, Mastodon, Instagram and Twitter/X.

## Requirements

- Kirby CMS 5.x
- PHP 8.1+

## Installation

### Git submodule

Add the plugin to your Kirby project:

```bash
git submodule add https://github.com/mirthe/kirby-socialembeds.git site/plugins/social-embeds
```

### Manual installation

Download or clone this repository into:

`site/plugins/social-embeds/`

## Usage

Use the following Kirby tags in your content:

### Bluesky

```text
(bluesky: url: https://bsky.app/profile/username/post/postid)
```

### Pixelfed

```text
(pixelfed: url: https://pixelfed.social/p/username/postid)
```

### Mastodon

```text
(mastodon: url: https://mastodon.social/@username/postid)
```

### Instagram

Coming soon.

### Twitter / X

Coming soon.

## Configuration

The plugin can be configured in your `site/config/config.php`:

```php
return [
    'mirthe.social-embeds' => [
        'cache'     => true,
        'maxwidth'  => 600,
        'colorMode' => 'system',
    ],
];
```

### Options

| Option | Default | Description |
|---|---|---|
| `cache` | `true` | Enable caching of API responses |
| `maxwidth` | `600` | Maximum width of embeds |
| `colorMode` | `system` | Bluesky embed color mode (`system`, `light`, `dark`) |

Caching is used for platforms that retrieve embed HTML through an API. Platforms that generate embed URLs directly do not require caching.

## License

MIT
