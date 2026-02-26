<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Plugin\Catalog;

use Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface;
use Magento\Catalog\Model\Category\Image as Subject;

class CategoryImagePlugin
{
    /**
     * @param RemoteMediaUrlRewriterInterface $urlRewriter
     */
    public function __construct(
        private RemoteMediaUrlRewriterInterface $urlRewriter,
    ) {
    }

    /**
     * Rewrite generated media URLs to remote media URLs.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Subject $subject
     * @param string $result
     * @return string
     */
    public function afterGetUrl(Subject $subject, string $result): string
    {
        return $this->urlRewriter->rewrite($result);
    }
}
