<?php

namespace BenTools\HostnameExtractor\SuffixProvider;

use Psr\SimpleCache\CacheInterface;

final class PSR16CacheSuffixProvider implements SuffixProviderInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var PublicSuffixProvider
     */
    private $suffixProvider;

    /**
     * @var string
     */
    private $key;

    /**
     *  constructor.
     * @param CacheInterface       $cache
     * @param PublicSuffixProvider $suffixProvider
     */
    public function __construct(
        CacheInterface $cache,
        SuffixProviderInterface $suffixProvider,
        string $key = 'suffix_list'
    ) {
        $this->cache = $cache;
        $this->suffixProvider = $suffixProvider;
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function getSuffixes(): iterable
    {
        if (!$this->cache->has($this->key)) {
            $suffixes = iterable_to_array($this->suffixProvider->getSuffixes());
            $this->cache->set($this->key, $suffixes);
            return $suffixes;
        }
        return $this->cache->get($this->key);
    }
}
