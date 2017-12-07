<?php

namespace BenTools\HostnameExtractor\Tests;

use BenTools\HostnameExtractor\HostnameExtractor;
use BenTools\HostnameExtractor\SuffixProvider\PublicSuffixProvider;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class HostnameExtractorTest extends TestCase
{
    /**
     * @var HostnameExtractor
     */
    public static $extractor;

    public static function setUpBeforeClass()
    {
        self::$extractor = new HostnameExtractor(
            new PublicSuffixProvider(
                new Client()
            )
        );
    }


    /**
     * @dataProvider dataProvider
     *
     * @param string      $testedHostname
     * @param null|string $expectedSubdomain
     * @param null|string $expectedDomain
     * @param null|string $expectedSuffix
     * @param null|string $expectedTld
     * @throws \InvalidArgumentException
     */
    public function testExtract(
        string $testedHostname,
        ?string $expectedSubdomain,
        ?string $expectedDomain,
        ?string $expectedSuffix,
        ?string $expectedSuffixedDomain,
        ?string $expectedTld,
        bool $expectedIsIp
)
    {
        $parsed = self::$extractor->extract($testedHostname);
        $this->assertSame($expectedSubdomain, $parsed->getSubdomain());
        $this->assertSame($expectedDomain, $parsed->getDomain());
        $this->assertSame($expectedSuffix, $parsed->getSuffix());
        $this->assertSame($expectedSuffixedDomain, $parsed->getSuffixedDomain());
        $this->assertSame($expectedTld, $parsed->getTld());
        $this->assertSame($expectedIsIp, $parsed->isIpv4());
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [
                'localhost',
                null, // expected subdomain
                'localhost', // expected domain
                null, // expected suffix
                'localhost', // expected domain + suffix
                null, // expected tld,
                false, // is IP
            ],
            [
                'example.org',
                null, // expected subdomain
                'example', // expected domain
                'org', // expected suffix
                'example.org', // expected domain + suffix
                'org', // expected tld,
                false, // is IP
            ],
            [
                'my.example.org',
                'my', // expected subdomain
                'example', // expected domain
                'org', // expected suffix
                'example.org', // expected domain + suffix
                'org', // expected tld,
                false, // is IP
            ],
            [
                'my.second.example.org',
                'my.second', // expected subdomain
                'example', // expected domain
                'org', // expected suffix
                'example.org', // expected domain + suffix
                'org', // expected tld,
                false, // is IP
            ],
            [
                'example.co.uk',
                null, // expected subdomain
                'example', // expected domain
                'co.uk', // expected suffix
                'example.co.uk', // expected domain + suffix
                'uk', // expected tld,
                false, // is IP
            ],
            [
                'my.example.co.uk',
                'my', // expected subdomain
                'example', // expected domain
                'co.uk', // expected suffix
                'example.co.uk', // expected domain + suffix
                'uk', // expected tld,
                false, // is IP
            ],
            [
                'my.second.example.co.uk',
                'my.second', // expected subdomain
                'example', // expected domain
                'co.uk', // expected suffix
                'example.co.uk', // expected domain + suffix
                'uk', // expected tld,
                false, // is IP
            ],
            [
                'example.co.unknown',
                'example', // expected subdomain
                'co', // expected domain
                'unknown', // expected suffix
                'co.unknown', // expected domain + suffix
                'unknown', // expected tld,
                false, // is IP
            ],
            [
                '127.0.0.1',
                null, // expected subdomain
                null, // expected domain
                null, // expected suffix
                '', // expected domain + suffix
                null, // expected tld,
                true, // is IP
            ],
            [
                '2001:0db8:0a0b:12f0:0000:0000:0000:0001',
                null, // expected subdomain
                null, // expected domain
                null, // expected suffix
                '', // expected domain + suffix
                null, // expected tld,
                true, // is IP
            ],
        ];
    }
}
