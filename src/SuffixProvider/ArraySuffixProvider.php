<?php

namespace BenTools\HostnameExtractor\SuffixProvider;

use function BenTools\Violin\string;

final class ArraySuffixProvider implements SuffixProviderInterface
{
    /**
     * @var array
     */
    private $suffixes;

    /**
     * ArraySuffixProvider constructor.
     */
    public function __construct(array $suffixes)
    {
        \usort(
            $suffixes,
            function ($a, $b) {
                return \count(string($b)) <=> \count(string($a));
            }
        );
        $this->suffixes = $suffixes;
    }

    public function getSuffixes(): iterable
    {
        return $this->suffixes;
    }
}
