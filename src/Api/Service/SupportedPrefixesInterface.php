<?php

declare(strict_types=1);

namespace Augustash\RemoteMedia\Api\Service;

/**
 * Service contract for supported remote media prefixes.
 */
interface SupportedPrefixesInterface
{
    /**
     * Return supported prefixes after /media/.
     *
     * @return string[]
     */
    public function execute(): array;
}
