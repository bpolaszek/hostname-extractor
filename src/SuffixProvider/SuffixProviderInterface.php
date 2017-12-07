<?php

namespace BenTools\HostnameExtractor\SuffixProvider;

interface SuffixProviderInterface
{

    /**
     * Return all known suffixes.
     * The implementation MUST yield suffixes sorted by length DESC.
     *
     * @return iterable
     */
    public function getSuffixes(): iterable;
}
