[![Latest Stable Version](https://poser.pugx.org/bentools/hostname-extractor/v/stable)](https://packagist.org/packages/bentools/hostname-extractor)
[![License](https://poser.pugx.org/bentools/hostname-extractor/license)](https://packagist.org/packages/bentools/hostname-extractor)
[![Build Status](https://img.shields.io/travis/bpolaszek/hostname-extractor/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/hostname-extractor)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/hostname-extractor/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/hostname-extractor?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/hostname-extractor.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/hostname-extractor)
[![Total Downloads](https://poser.pugx.org/bentools/hostname-extractor/downloads)](https://packagist.org/packages/bentools/hostname-extractor)

# Hostname Extractor

A simple library to manipulate domains.

## Usage

```php
require_once __DIR__ . '/vendor/autoload.php';

use BenTools\HostnameExtractor\HostnameExtractor;
use BenTools\HostnameExtractor\SuffixProvider\PublicSuffixProvider;
use GuzzleHttp\Client;

$extractor = new HostnameExtractor(new PublicSuffixProvider(new Client()));
$hostname = $extractor->extract('my.preferred.domain.co.uk');
dump($hostname->getSubdomain()); // my.preferred
dump($hostname->getDomain()); // domain
dump($hostname->getSuffix()); // co.uk
dump($hostname->getTld()); // uk
dump($hostname->getSuffixedDomain()); // domain.co.uk
dump($hostname->isIp()); // false
dump($hostname->isIpv4()); // false
dump($hostname->isIpv6()); // false
```

As you can see, `co.uk` is considered as a suffix (otherwise, we would have considered that `co` is the domain and `uk` the suffix / tld).

The library parses the [Public Suffix List](https://publicsuffix.org/), which stores thousands of existing suffixes.

To avoid network latency feel free to implement your own `BenTools\HostnameExtractor\SuffixProvider\SuffixProviderInterface`.

## Installation

PHP 7.1+ with `mbstring` extension is required.

> composer require bentools/hostname-extractor ^1.0

## Tests

> ./vendor/bin/phpunit

## License

MIT.

## See also

[bentools/querystring](https://github.com/bpolaszek/querystring) - Easily manipulate your query strings.

[bentools/uri-factory](https://github.com/bpolaszek/uri-factory) - PSR-7 `UriInterface` factory with multiple libaries support.