<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Service;

use Augustash\RemoteMedia\Api\Service\SupportedPrefixesInterface;

class SupportedPrefixes implements SupportedPrefixesInterface
{
    /**
     * Return supported prefixes after /media/.
     *
     * @return string[]
     */
    public function execute(): array
    {
        return [
            '.renditions/',
            '.thumbsstores/',
            '.thumbswysiwyg/',
            'amasty/',
            'attribute/',
            'catalog/',
            'customer_address/',
            'email/',
            'favicon/',
            'logo/',
            'stores/',
            'theme/',
            'wysiwyg/',
        ];
    }
}
