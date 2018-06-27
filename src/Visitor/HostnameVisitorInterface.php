<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;

/**
 * Interface HostnameVisitorInterface
 * @internal
 */
interface HostnameVisitorInterface
{

    /**
     * @param                $hostname
     * @param ParsedHostname $parsedHostname
     */
    public function visit($hostname, ParsedHostname $parsedHostname): void;
}
