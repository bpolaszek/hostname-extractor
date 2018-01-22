<?php

namespace BenTools\HostnameExtractor\Tests;

use BenTools\HostnameExtractor\SuffixProvider\PublicSuffixProvider;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PublicSuffixProviderTest extends TestCase
{

    public function testGetSuffixes()
    {
        $provider = new PublicSuffixProvider(new Client());
        $suffixes = iterable_to_array($provider->getSuffixes());
        $this->assertGreaterThan(8000, count($suffixes));
        foreach ($suffixes as $suffix) {

            $this->assertInternalType('string', $suffix);
            $this->assertStringStartsNotWith('//', $suffix);
            $this->assertStringStartsNotWith('*', $suffix);
            $this->assertStringStartsNotWith('.', $suffix);

            $currentCount = mb_strlen($suffix);
            if (isset($previousCount)) {
                $this->assertLessThanOrEqual($previousCount, $currentCount);
            }
            $previousCount = $currentCount;
        }
    }
}
