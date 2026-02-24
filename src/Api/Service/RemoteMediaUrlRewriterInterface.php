<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Api\Service;

/**
 * Service interface responsible for remote media URL rewriting.
 *
 * @api
 */
interface RemoteMediaUrlRewriterInterface
{
    /**
     * Rewrite a media URL when remote media is enabled.
     *
     * @param string $url
     * @param int|null $storeId
     * @return string
     */
    public function rewrite(string $url, ?int $storeId = null): string;

    /**
     * Rewrite supported media URLs inside HTML content.
     *
     * @param string $html
     * @param int|null $storeId
     * @return string
     */
    public function rewriteHtml(string $html, ?int $storeId = null): string;
}
