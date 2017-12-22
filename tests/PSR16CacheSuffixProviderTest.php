<?php

namespace BenTools\HostnameExtractor\Tests;

use BenTools\HostnameExtractor\SuffixProvider\PSR16CacheSuffixProvider;
use BenTools\HostnameExtractor\SuffixProvider\PublicSuffixProvider;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;

class PSR16CacheSuffixProviderTest extends TestCase
{

    public function testGetSuffixes()
    {
        $publicSuffixProvider = new PublicSuffixProvider(new Client());
        $cache = new ArrayCache(0, false);
        $cacheProvider = new PSR16CacheSuffixProvider($cache, $publicSuffixProvider, 'foobar');
        $this->assertFalse($cache->has('foobar'));

        $suffixes = $cacheProvider->getSuffixes();

        $this->assertInternalType('array', $suffixes);
        $this->assertGreaterThan(8000, count($suffixes));
        $this->assertTrue($cache->has('foobar'));
        $this->assertSame($suffixes, $cache->get('foobar'));
    }
}
