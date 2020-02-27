<?php

namespace Trisk\Glip\ValueObjects;

/**
 * Class RingCentralCredentials
 *
 * @package Trisk\Glip\ValueObjects
 */
final class ClientCredentials
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
     * RingCentralCredentials constructor.
     *
     * @param string $clientSecret
     * @param string $clientId
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
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
}