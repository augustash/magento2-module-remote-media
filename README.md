# Magento 2 Module - Augustash Remote Media

<!-- markdownlint-disable MD033 -->
<div align="center">
    <a href="https://augustash.com" target="_blank">
        <picture>
            <source media="(prefers-color-scheme: dark)" srcset="https://augustash.s3.amazonaws.com/logos/ash-inline-invert-500.png">
            <source media="(prefers-color-scheme: light)" srcset="https://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png">
            <img alt="Shows a theme-dependent version of the AAI company logo." src="https://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png">
        </picture>
    </a>
</div>

<div align="center">
    <img src="https://img.shields.io/badge/magento-2.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
    <a href="https://github.com/augustash/magento2-module-remote-media/graphs/commit-activity" target="_blank">
        <img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square" alt="Maintained - Yes" />
    </a>
</div>

## Overview

**This is a Hyvä-compatibile module with the Hyvä Theme & Hyvä CSP Theme.**

The `Augustash_RemoteMedia` module is the allows a development project to load media assets from a remote source instead of the local Magento instance. This can be useful for development environments where media assets are not available.

## Installation

### Via Composer

Install the extension using Composer from our development package repository:

```bash
composer require augustash/module-remote-media
bin/magento module:enable --clear-static-content Augustash_RemoteMedia
bin/magento setup:upgrade
bin/magento cache:flush
```

## Structure

[Typical file structure for Magento 2 modules](https://developer.adobe.com/commerce/php/development/build/component-file-structure/).
