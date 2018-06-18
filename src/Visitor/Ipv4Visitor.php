<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use Stringy\Stringy;

/**
 * Class Ipv4Visitor
 * @internal
 */
final class Ipv4Visitor implements HostnameVisitorInterface
{

    /**
     * @inheritDoc
     */
    public function visit(Stringy $hostname, ParsedHostname $parsedHostname): void
    {
        if (false !== filter_var((string) $hostname, FILTER_VALIDATE_IP)) {
            $parsedHostname->setIsIpv4(true);
        }
    }
}
