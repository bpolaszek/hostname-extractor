<?php

namespace BenTools\HostnameExtractor\SuffixProvider;

use CallbackFilterIterator;
use GuzzleHttp\Client;

class PublicSuffixProvider implements SuffixProviderInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $listUrl;

    /**
     * @var array
     */
    private $cache;

    /**
     * @inheritDoc
     */
    public function __construct(
        Client $client,
        string $listUrl = 'https://publicsuffix.org/list/public_suffix_list.dat'
    ) {
    
        $this->client = $client;
        $this->listUrl = $listUrl;
    }

    /**
     * @param bool $force
     */
    public function fetchSuffixes(bool $force = false): void
    {
        if (null === $this->cache || true === $force) {
            $content = $this->client->get($this->listUrl)->getBody();
            // Create an iterator for the document
            $iterator = (function (string $content) {
                $tok = strtok($content, "\r\n");
                while (false !== $tok) {
                    $line = $tok;
                    $tok = strtok("\r\n");

                    // Remove "*." prefixes
                    if (0 === strpos($line, '*.')) {
                        $line = substr($line, 2, mb_strlen($line) - 2);
                    }

                    yield $line;
                }
            })($content);

            // Ignore commented lines
            $valid = function (string $string) {
                return 0 !== strpos($string, '//');
            };
            $suffixes = iterator_to_array(new CallbackFilterIterator($iterator, $valid));

            // Sort by suffix length
            usort($suffixes, function ($a, $b) {
                return mb_strlen($b) <=> mb_strlen($a);
            });

            $this->cache = $suffixes;
        }
    }

    /**
     * @inheritDoc
     */
    public function getSuffixes(): iterable
    {
        $this->fetchSuffixes();
        yield from $this->cache ?? new \EmptyIterator();
    }
}
