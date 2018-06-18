<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use Stringy\Stringy;

/**
 * Class IPv6Visitor
 * @internal
 */
final class IPv6Visitor implements HostnameVisitorInterface
{
    /**
     * @inheritDoc
     */
    public function visit(Stringy $hostname, ParsedHostname $parsedHostname): void
    {
        if ($hostname->startsWith('[') && $hostname->endsWith(']')) {
            $ipv6 = (string) $hostname->removeLeft('[')->removeRight(']');
            if (filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $parsedHostname->setIsIpv6(true);
            }
        }
    }
}
