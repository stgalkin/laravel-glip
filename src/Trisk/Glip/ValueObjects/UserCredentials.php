<?php

namespace Trisk\Glip\ValueObjects;

/**
 * Class GlipUserCredentials
 *
 * @package Trisk\Glip\ValueObjects
 */
final class UserCredentials
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * RingCentralCredentials constructor.
     *
     * @param string $password
     * @param string $username
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}