<?php

namespace App\Models\tags;

class Code
{
    /**
     * @var int
     */
    private $key;

    /**
     * @var string
     */
    private $message;


    /**
     * @return int|null
     */
    public function getKey(): ?int
    {
        return $this->key;
    }

    /**
     * @param int|null $key
     *
     * @return Code
     */
    public function setKey(?int $key): Code
    {
        $this->key = $key;
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     *
     * @return Code
     */
    public function setMessage(?string $message): Code
    {
        $this->message = $message;
        
        return $this;
    }
}

