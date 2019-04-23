<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use function BenTools\Violin\string;

/**
 * Class IPv6Visitor
 * @internal
 */
final class IPv6Visitor implements HostnameVisitorInterface
{
    /**
     * @inheritDoc
     */
    public function visit($hostname, ParsedHostname $parsedHostname): void
    {
        $hostname = string($hostname);
        if ($hostname->startsWith('[') && $hostname->endsWith(']')) {
            $ipv6 = (string) $hostname->removeLeft('[')->removeRight(']');
            if (\filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $parsedHostname->setIsIpv6(true);
            }
        }
    }
}
