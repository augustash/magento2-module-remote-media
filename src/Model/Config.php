<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Model;

use Augustash\RemoteMedia\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\App\State $appState
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected State $appState,
        protected ScopeConfigInterface $scopeConfig,
    ) {
    }

    /**
     * Returns the module's configured status.
     *
     * Includes developer-mode and base media URL validation.
     *
     * @param string $scope
     * @param string|int|null $scopeCode
     * @return bool
     */
    public function isEnabled(
        string $scope = ScopeInterface::SCOPE_STORES,
        string|int|null $scopeCode = null,
    ): bool {
        if (!$this->scopeConfig->isSetFlag(self::XML_PATH_REMOTE_MEDIA_ENABLED, $scope, $scopeCode)) {
            return false;
        }

        if ($this->appState->getMode() !== State::MODE_DEVELOPER) {
            return false;
        }

        return $this->getBaseMediaUrl($scope, $scopeCode) !== '';
    }

    /**
     * Returns the module's configured base media URL.
     *
     * URL is normalized with a trailing slash. Invalid values return an empty string.
     *
     * @param string $scope
     * @param string|int|null $scopeCode
     * @return string
     */
    public function getBaseMediaUrl(
        string $scope = ScopeInterface::SCOPE_STORES,
        string|int|null $scopeCode = null,
    ): string {
        $value = (string) $this->scopeConfig->getValue(
            self::XML_PATH_REMOTE_MEDIA_BASE_URL,
            $scope,
            $scopeCode,
        );

        return $this->normalizeMediaBaseUrl($value);
    }

    /**
     * Normalize and validate configured base media URL.
     *
     * @param string $url
     * @return string
     */
    private function normalizeMediaBaseUrl(string $url): string
    {
        $url = \trim($url);
        if ($url === '' || !\filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        $normalized = \rtrim($url, '/') . '/';
        // phpcs:ignore Magento2.Functions.DiscouragedFunction.Discouraged
        $parts = \parse_url($normalized);
        if (!\is_array($parts)) {
            return '';
        }

        $scheme = \strtolower((string) ($parts['scheme'] ?? ''));
        if (!\in_array($scheme, ['http', 'https'], true)) {
            return '';
        }

        $path = \strtolower((string) ($parts['path'] ?? ''));
        if (!\str_ends_with(\rtrim($path, '/') . '/', '/media/')) {
            return '';
        }

        return $normalized;
    }
}
