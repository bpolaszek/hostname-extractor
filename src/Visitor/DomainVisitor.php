<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use Stringy\Stringy;

/**
 * Class DomainVisitor
 * @internal
 */
final class DomainVisitor implements HostnameVisitorInterface
{

    /**
     * @inheritDoc
     */
    public function visit(Stringy $hostname, ParsedHostname $parsedHostname): void
    {
        if (!$parsedHostname->isIp()) {
            $suffix = $parsedHostname->getSuffix();
            $withoutSuffix = null !== $suffix ? $hostname->removeRight(sprintf('.%s', $suffix)) : $hostname;
            if ($withoutSuffix->contains('.')) {
                $domainParts = explode('.', (string) $withoutSuffix);
                $parsedHostname->setDomain(array_pop($domainParts));
                $parsedHostname->setSubdomain(implode('.', $domainParts));
            } else {
                $parsedHostname->setDomain((string) $withoutSuffix);
            }
        }
    }
}
