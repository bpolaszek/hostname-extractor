<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;

/**
 * Class Ipv4Visitor
 * @internal
 */
final class Ipv4Visitor implements HostnameVisitorInterface
{

    /**
     * @inheritDoc
     */
    public function visit($hostname, ParsedHostname $parsedHostname): void
    {
        if (false !== \filter_var((string) $hostname, FILTER_VALIDATE_IP)) {
            $parsedHostname->setIsIpv4(true);
        }
    }
}
