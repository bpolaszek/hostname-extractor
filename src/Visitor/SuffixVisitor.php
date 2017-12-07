<?php

namespace BenTools\HostnameExtractor\Visitor;

use BenTools\HostnameExtractor\ParsedHostname;
use BenTools\HostnameExtractor\SuffixProvider\SuffixProviderInterface;
use Stringy\Stringy;

/**
 * Class SuffixVisitor
 * @internal
 */
class SuffixVisitor implements HostnameVisitorInterface
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
    public function visit(Stringy $hostname, ParsedHostname $parsedHostname): void
    {
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
     * @param Stringy $hostname
     * @return null|string
     */
    private function findSuffix(Stringy $hostname): ?string
    {
        foreach ($this->suffixProvider->getSuffixes() as $suffix) {
            if ($hostname->endsWith($suffix)) {
                return $suffix;
            }
        }
        return null;
    }
}
