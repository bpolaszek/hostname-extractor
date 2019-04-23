<?php

namespace BenTools\HostnameExtractor\SuffixProvider;

/**
 * As this class will provide no suffix, substring after last dot may be used to determine hostname's suffix.
 */
final class NaiveSuffixProvider implements SuffixProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getSuffixes(): iterable
    {
        return [];
    }
}
