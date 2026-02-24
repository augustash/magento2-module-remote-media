<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Plugin\Catalog;

use Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface;
use Magento\Catalog\Model\View\Asset\Image as Subject;

class ViewAssetImagePlugin
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface $urlRewriter
     */
    public function __construct(
        private RemoteMediaUrlRewriterInterface $urlRewriter,
    ) {
    }

    /**
     * Rewrite generated image asset URLs to remote media URLs.
     *
     * @param \Magento\Catalog\Model\View\Asset\Image $subject
     * @param string $result
     * @return string
     */
    public function afterGetUrl(Subject $subject, string $result): string
    {
        return $this->urlRewriter->rewrite($result);
    }
}
