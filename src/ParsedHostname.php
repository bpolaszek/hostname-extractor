<?php
declare(strict_types=1);

namespace BenTools\HostnameExtractor;

final class ParsedHostname
{
    /**
     * @var string
     */
    private $subdomain;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $suffix;

    /**
     * @var string
     */
    private $tld;

    /**
     * @var bool
     */
    private $isIpv4 = false;

    /**
     * @var bool
     */
    private $isIpv6 = false;

    /**
     * @return string
     */
    public function getSubdomain(): ?string
    {
        return $this->subdomain;
    }

    /**
     * @param string $subdomain
     */
    public function setSubdomain(string $subdomain): void
    {
        $this->subdomain = $subdomain;
    }

    /**
     * @return string
     */
    public function getSuffixedDomain(): string
    {
        return implode(
            '.',
            array_filter(
                [
                    $this->getDomain(),
                    $this->getSuffix(),
                ],
                function ($part) {
                    return null !== $part;
                }
            )
        );
    }

    /**
     * @return string
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix(string $suffix): void
    {
        $this->suffix = $suffix;
    }

    /**
     * @return string
     */
    public function getTld(): ?string
    {
        return $this->tld;
    }

    /**
     * @param string $tld
     */
    public function setTld(string $tld): void
    {
        $this->tld = $tld;
    }

    /**
     * @return bool
     */
    public function isIpv4(): bool
    {
        return $this->isIpv4;
    }

    /**
     * @param bool $isIpv4
     */
    public function setIsIpv4(bool $isIpv4): void
    {
        $this->isIpv4 = $isIpv4;
    }

    /**
     * @return bool
     */
    public function isIpv6(): ?bool
    {
        return $this->isIpv6;
    }

    /**
     * @param bool $isIpv6
     */
    public function setIsIpv6(bool $isIpv6): void
    {
        $this->isIpv6 = $isIpv6;
    }

    /**
     * @return bool
     */
    public function isIp(): bool
    {
        return $this->isIpv4() || $this->isIpv6();
    }

    /**
     * @return ParsedHostname
     */
    public static function new(): self
    {
        static $prototype;
        if (!isset($prototype)) {
            $prototype = new static;
        }
        return clone $prototype;
    }
}
