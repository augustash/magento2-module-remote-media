<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Service;

use Augustash\RemoteMedia\Api\ConfigInterface;
use Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface;
use Augustash\RemoteMedia\Api\Service\SupportedPrefixesInterface;
use Magento\Store\Model\ScopeInterface;

class RemoteMediaUrlRewriter implements RemoteMediaUrlRewriterInterface
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\RemoteMedia\Api\ConfigInterface $config
     * @param \Augustash\RemoteMedia\Api\Service\SupportedPrefixesInterface $supportedPrefixes
     */
    public function __construct(
        private ConfigInterface $config,
        private SupportedPrefixesInterface $supportedPrefixes,
    ) {
    }

    /**
     * Rewrite a media URL when remote media is enabled.
     *
     * @param string $url
     * @param int|null $storeId
     * @return string
     */
    public function rewrite(string $url, ?int $storeId = null): string
    {
        if ($url === '') {
            return $url;
        }

        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORES, $storeId)) {
            return $url;
        }

        $baseMediaUrl = $this->config->getBaseMediaUrl(ScopeInterface::SCOPE_STORES, $storeId);
        if ($baseMediaUrl === '') {
            return $url;
        }

        $relativePath = $this->extractRelativeMediaPath($url);
        if ($relativePath === null) {
            return $url;
        }

        return $baseMediaUrl . $relativePath;
    }

    /**
     * Rewrite supported media URLs inside HTML content.
     *
     * @param string $html
     * @param int|null $storeId
     * @return string
     */
    public function rewriteHtml(string $html, ?int $storeId = null): string
    {
        if ($html === '') {
            return $html;
        }

        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORES, $storeId)) {
            return $html;
        }

        $result = \preg_replace_callback(
            '/(https?:\/\/[^\s"\'\)<>]+|\/\/[^\s"\'\)<>]+|\/?pub\/media\/[^\s"\'\)<>]+|\/?media\/[^\s"\'\)<>]+)/i',
            fn (array $matches): string => $this->rewrite((string) $matches[0], $storeId),
            $html,
        );

        return $result ?? $html;
    }

    /**
     * Extract supported media path relative to /media/.
     *
     * @param string $value
     * @return string|null
     */
    private function extractRelativeMediaPath(string $value): ?string
    {
        $value = \trim($value);
        if ($value === '') {
            return null;
        }

        $path = $this->extractPath($value);
        $path = \ltrim($path, '/');

        if (\str_starts_with($path, 'pub/media/')) {
            $path = (string) \substr($path, \strlen('pub/media/'));
        } elseif (\str_starts_with($path, 'media/')) {
            $path = (string) \substr($path, \strlen('media/'));
        } else {
            return null;
        }

        foreach ($this->supportedPrefixes->execute() as $supportedPrefix) {
            if (\str_starts_with($path, $supportedPrefix)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Extract path component from URL or return the original value.
     *
     * @param string $value
     * @return string
     */
    private function extractPath(string $value): string
    {
        // phpcs:ignore Magento2.Functions.DiscouragedFunction.Discouraged
        $absoluteParts = \parse_url($value);
        if (\is_array($absoluteParts) && isset($absoluteParts['scheme'], $absoluteParts['host'])) {
            return (string) ($absoluteParts['path'] ?? '');
        }

        if (\str_starts_with($value, '//')) {
            // phpcs:ignore Magento2.Functions.DiscouragedFunction.Discouraged
            $schemeRelativePath = \parse_url('https:' . $value, PHP_URL_PATH);
            return \is_string($schemeRelativePath) ? $schemeRelativePath : '';
        }

        return $value;
    }
}
