<?php

namespace Trisk\Glip\ValueObjects;

/**
 * Class RingCentralCredentials
 *
 * @package Trisk\Glip\ValueObjects
 */
final class RingCentralCredentials
{
    /**
     * @var string
     */
    private $clientName;

    /**
     * @var string
     */
    private $clientId;

    /**
     * RingCentralCredentials constructor.
     *
     * @param string $clientName
     * @param string $clientId
     */
    public function __construct(string $clientId, string $clientName)
    {
        $this->clientName = $clientName;
        $this->clientId = $clientId;
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
    public function clientName(): string
    {
        return $this->clientName;
    }
}