<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use BenTools\HostnameExtractor\SuffixProvider\SuffixProviderInterface;
use function BenTools\Violin\string;
use BenTools\Violin\Violin;

/**
 * Class SuffixVisitor
 * @internal
 */
final class SuffixVisitor implements HostnameVisitorInterface
{
    /**
     * @var SuffixProviderInterface
     */
    private $suffixProvider;

    /**
     * @inheritDoc
     */
    public function __construct(SuffixProviderInterface $suffixProvider)
    {
        $this->suffixProvider = $suffixProvider;
    }

    /**
     * @inheritDoc
     */
    public function visit($hostname, ParsedHostname $parsedHostname): void
    {
        $hostname = string($hostname);
        if (!$parsedHostname->isIp() && $hostname->contains('.')) {
            $suffix = $this->findSuffix($hostname);
            if (null !== $suffix) {
                $parsedHostname->setSuffix($suffix);
            } else {
                $hostnameParts = explode('.', $hostname);
                $parsedHostname->setSuffix(array_pop($hostnameParts));
            }
        }
    }

    /**
     * @param Violin $hostname
     * @return null|string
     */
    private function findSuffix(Violin $hostname): ?string
    {
        foreach ($this->suffixProvider->getSuffixes() as $suffix) {
            if ($hostname->endsWith(sprintf('.%s', $suffix))) {
                return $suffix;
            }
        }
        return null;
    }
}
