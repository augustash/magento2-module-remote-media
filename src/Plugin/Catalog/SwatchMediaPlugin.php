<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Plugin\Catalog;

use Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface;
use Magento\Swatches\Helper\Media as Subject;

class SwatchMediaPlugin
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
     * Rewrite generated swatch base media URL.
     *
     * @param \Magento\Swatches\Helper\Media $subject
     * @param string $result
     * @return string
     */
    public function afterGetSwatchMediaUrl(Subject $subject, string $result): string
    {
        return $this->urlRewriter->rewrite($result);
    }

    /**
     * Rewrite generated swatch image URLs.
     *
     * @param \Magento\Swatches\Helper\Media $subject
     * @param string $result
     * @return string
     */
    public function afterGetSwatchAttributeImage(Subject $subject, string $result): string
    {
        return $this->urlRewriter->rewrite($result);
    }
}
