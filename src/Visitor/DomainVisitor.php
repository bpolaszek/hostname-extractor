<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use function BenTools\Violin\string;

/**
 * Class DomainVisitor
 * @internal
 */
final class DomainVisitor implements HostnameVisitorInterface
{

    /**
     * @inheritDoc
     */
    public function visit($hostname, ParsedHostname $parsedHostname): void
    {
        $hostname = string($hostname);
        if (!$parsedHostname->isIp()) {
            $suffix = $parsedHostname->getSuffix();
            $withoutSuffix = null !== $suffix ? $hostname->removeRight(\sprintf('.%s', $suffix)) : $hostname;
            if ($withoutSuffix->contains('.')) {
                $domainParts = \explode('.', (string) $withoutSuffix);
                $parsedHostname->setDomain(\array_pop($domainParts));
                $parsedHostname->setSubdomain(\implode('.', $domainParts));
            } else {
                $parsedHostname->setDomain((string) $withoutSuffix);
            }
        }
    }
}
