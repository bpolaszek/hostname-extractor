<?php

namespace BenTools\HostnameExtractor\SuffixProvider;

use Psr\SimpleCache\CacheInterface;

class PSR16CacheSuffixProvider implements SuffixProviderInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var PublicSuffixProvider
     */
    private $publicSuffixProvider;

    /**
     * @var string
     */
    private $key;

    /**
     *  constructor.
     * @param CacheInterface       $cache
     * @param PublicSuffixProvider $publicSuffixProvider
     */
    public function __construct(
        CacheInterface $cache,
        PublicSuffixProvider $publicSuffixProvider,
        string $key = 'suffix_list'
    ) {
        $this->cache = $cache;
        $this->publicSuffixProvider = $publicSuffixProvider;
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function getSuffixes(): iterable
    {
        if (!$this->cache->has($this->key)) {
            $suffixes = iterable_to_array($this->publicSuffixProvider->getSuffixes());
            $this->cache->set($this->key, $suffixes);
            return $suffixes;
        }
        return $this->cache->get($this->key);
    }
}
