<?php

namespace Trisk\Glip\ValueObjects\Response;

/**
 * Class ChatRecord
 *
 * @package Trisk\Glip\ValueObjects\Response
 */
final class ChatRecord
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $creatorId;

    /**
     * @param string $id
     * @param string $text
     * @param string $creatorId
     */
    public function __construct(string $id, string $text, string $creatorId)
    {
        $this->id = $id;
        $this->text = $text;
        $this->creatorId = $creatorId;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function creatorId(): string
    {
        return $this->creatorId;
    }
}