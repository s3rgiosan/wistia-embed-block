# Wistia Embed Block

> A block for embedding Wistia videos in the WordPress block editor.

## Description

The Wistia Embed block enables you to easily embed Wistia videos directly in the WordPress block editor. No need for shortcodes or manual HTML; simply paste the Wistia video link, and the block takes care of the rest.

## Requirements

- WordPress 6.7 or later
- PHP 7.4 or later

## Supported URL Formats

The plugin recognizes the following Wistia URL patterns:

- `https://<subdomain>.wistia.com/medias/<video-id>`
- `https://<subdomain>.wistia.com/embed/<video-id>`
- `https://<subdomain>.wi.st/medias/<video-id>`
- `https://<subdomain>.wistia.net/medias/<video-id>`

## Installation

### Manual Installation

1. Download the plugin ZIP file from the GitHub repository.
2. Go to Plugins > Add New > Upload Plugin in your WordPress admin area.
3. Upload the ZIP file and click Install Now.
4. Activate the plugin.

### Install with Composer

To include this plugin as a dependency in your Composer-managed WordPress project:

1. Add the plugin to your project using the following command:

```bash
composer require s3rgiosan/wistia-embed-block
```

2. Run `composer install` to install the plugin.
3. Activate the plugin from your WordPress admin area or using WP-CLI.

## Usage

1. In the block editor, add a new block and search for "Wistia Embed", or simply paste a Wistia video URL into the editor.
2. The block will automatically detect the Wistia URL and render a responsive video embed.

## Changelog

A complete listing of all notable changes to this project are documented in [CHANGELOG.md](https://github.com/s3rgiosan/wistia-embed-block/blob/main/CHANGELOG.md).
