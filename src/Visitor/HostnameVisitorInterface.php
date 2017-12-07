<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use Stringy\Stringy;

/**
 * Interface HostnameVisitorInterface
 * @internal
 */
interface HostnameVisitorInterface
{

    /**
     * @param Stringy        $hostname
     * @param ParsedHostname $parsedHostname
     */
    public function visit(Stringy $hostname, ParsedHostname $parsedHostname): void;
}
