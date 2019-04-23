<?php

namespace BenTools\HostnameExtractor\Tests;

use BenTools\HostnameExtractor\SuffixProvider\ArraySuffixProvider;
use PHPUnit\Framework\TestCase;

class ArraySuffixProviderTest extends TestCase
{
    /**
     * @test
     */
    public function it_provides_suffixes_in_the_correct_order()
    {
        $suffixes = [
            '.com',
            '.co.uk',
            '.au',
        ];

        $provider = new ArraySuffixProvider($suffixes);
        $expected = [
            '.co.uk',
            '.com',
            '.au',
        ];

        $this->assertSame($expected, $provider->getSuffixes());
    }
}
