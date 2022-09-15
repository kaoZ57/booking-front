<?php

namespace App\Models\tags;

class Response
{
    /**
     * @var Code
     */
    private $code;

    /**
     * @var Tag
     */
    private $tag;


    /**
     * @return Code|null
     */
    public function getCode(): ?Code
    {
        return $this->code;
    }

    /**
     * @param Code|null $code
     *
     * @return Response
     */
    public function setCode(?Code $code): Response
    {
        $this->code = $code;
        
        return $this;
    }

    /**
     * @return Tag|null
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * @param Tag|null $tag
     *
     * @return Response
     */
    public function setTag(?Tag $tag): Response
    {
        $this->tag = $tag;
        
        return $this;
    }
}

