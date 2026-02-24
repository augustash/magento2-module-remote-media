<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Plugin\Cms;

use Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;

class CmsHtmlRewritePlugin
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface $urlRewriter
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        private RemoteMediaUrlRewriterInterface $urlRewriter,
        private State $appState,
    ) {
    }

    /**
     * Rewrite hardcoded media URLs in rendered CMS HTML.
     *
     * @param mixed $subject
     * @param string $result
     * @return string
     */
    public function afterToHtml(mixed $subject, string $result): string
    {
        if (!$this->isFrontendArea()) {
            return $result;
        }

        return $this->urlRewriter->rewriteHtml($result);
    }

    /**
     * Check whether current area code is frontend.
     *
     * @return bool
     */
    private function isFrontendArea(): bool
    {
        try {
            return $this->appState->getAreaCode() === Area::AREA_FRONTEND;
        } catch (LocalizedException) {
            return false;
        }
    }
}
