<?php

namespace Trisk\Glip\ValueObjects;

/**
 * Class UserCredentials
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
     * @var string
     */
    private $extension;

    /**
     * @param string $username
     * @param string $password
     * @param string $extension
     */
    public function __construct(string $username, string $password, string $extension = '')
    {
        $this->username = $username;
        $this->password = $password;
        $this->extension = $extension;
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

    /**
     * @return string
     */
    public function extension(): string
    {
        return $this->extension;
    }
}