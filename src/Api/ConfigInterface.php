<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Api;

use Magento\Store\Model\ScopeInterface;

/**
 * Service interface responsible for module configuration.
 *
 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
 *
 * @api
 */
interface ConfigInterface
{
    /**
     * Configuration constants.
     */
    public const XML_PATH_REMOTE_MEDIA_ENABLED = 'dev/remote_media/enabled';
    public const XML_PATH_REMOTE_MEDIA_BASE_URL = 'dev/remote_media/base_media_url';

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
    ): bool;

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
    ): string;
}
