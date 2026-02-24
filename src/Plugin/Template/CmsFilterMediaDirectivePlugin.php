<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Plugin\Template;

use Augustash\RemoteMedia\Api\Service\RemoteMediaUrlRewriterInterface;
use Magento\Cms\Model\Template\Filter as Subject;

class CmsFilterMediaDirectivePlugin
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
     * Rewrite media directive output to remote media URL.
     *
     * @param \Magento\Cms\Model\Template\Filter $subject
     * @param string $result
     * @return string
     */
    public function afterMediaDirective(Subject $subject, string $result): string
    {
        return $this->urlRewriter->rewrite($result);
    }
}
