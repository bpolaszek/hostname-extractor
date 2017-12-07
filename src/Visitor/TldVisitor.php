<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use Stringy\Stringy;
use function Stringy\create as s;

/**
 * Class TldVisitor
 * @internal
 */
class TldVisitor implements HostnameVisitorInterface
{

    /**
     * @inheritDoc
     */
    public function visit(Stringy $hostname, ParsedHostname $parsedHostname): void
    {
        if (null !== $parsedHostname->getSuffix()) {
            $suffix = s($parsedHostname->getSuffix());
            if ($suffix->contains('.')) {
                $suffixParts = explode('.', (string) $suffix);
                $parsedHostname->setTld(array_pop($suffixParts));
            } else {
                $parsedHostname->setTld((string) $suffix);
            }
        }
    }
}
