<?php

namespace BenTools\HostnameExtractor;

use BenTools\HostnameExtractor\SuffixProvider\SuffixProviderInterface;
use BenTools\HostnameExtractor\Visitor\DomainVisitor;
use BenTools\HostnameExtractor\Visitor\HostnameVisitorInterface;
use BenTools\HostnameExtractor\Visitor\Ipv4Visitor;
use BenTools\HostnameExtractor\Visitor\IPv6Visitor;
use BenTools\HostnameExtractor\Visitor\SuffixVisitor;
use BenTools\HostnameExtractor\Visitor\TldVisitor;
use function BenTools\Violin\string;

final class HostnameExtractor
{
    /**
     * @var HostnameVisitorInterface[]
     */
    private $visitors;

    /**
     * HostnameExtractor constructor.
     *
     * @param SuffixProviderInterface|null $suffixProvider
     */
    public function __construct(SuffixProviderInterface $suffixProvider = null)
    {
        $this->visitors = [
            new IPv6Visitor(),
            new Ipv4Visitor(),
            new SuffixVisitor($suffixProvider),
            new TldVisitor(),
            new DomainVisitor(),
        ];
    }

    /**
     * @param string $hostname
     * @return ParsedHostname
     * @throws \InvalidArgumentException
     */
    public function extract(string $hostname): ParsedHostname
    {
        $hostname = string($hostname);
        $parsedHostname = ParsedHostname::new();
        foreach ($this->visitors as $visitor) {
            $visitor->visit($hostname, $parsedHostname);
        }
        return $parsedHostname;
    }
}
