<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use function BenTools\Violin\string;

/**
 * Class TldVisitor
 * @internal
 */
final class TldVisitor implements HostnameVisitorInterface
{

    /**
     * @inheritDoc
     */
    public function visit($hostname, ParsedHostname $parsedHostname): void
    {
        if (null !== $parsedHostname->getSuffix()) {
            $suffix = string($parsedHostname->getSuffix());
            if ($suffix->contains('.')) {
                $suffixParts = \explode('.', (string) $suffix);
                $parsedHostname->setTld(\array_pop($suffixParts));
            } else {
                $parsedHostname->setTld((string) $suffix);
            }
        }
    }
}
