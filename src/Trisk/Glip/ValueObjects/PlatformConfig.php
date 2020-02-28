<?php

namespace Trisk\Glip\ValueObjects;

/**
 * Class PlatformConfig
 *
 * @package Trisk\Glip\ValueObjects
 */
final class PlatformConfig
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $appVersion;

    /**
     * @var string
     */
    private $appName;

    /**
     * RingCentralCredentials constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $appVersion
     * @param string $appName
     */
    public function __construct(string $clientId, string $clientSecret, string $appVersion, string $appName)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->appVersion = $appVersion;
        $this->appName = $appName;
    }

    /**
     * @return string
     */
    public function clientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function clientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function appName(): string
    {
        return $this->appName;
    }

    /**
     * @return string
     */
    public function appVersion(): string
    {
        return $this->appName;
    }
}