<?php

namespace App\Models\tags;

class tags
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @var int
     */
    public $status;


    public function set($data)
    {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }

    /**
     * @return Response|null
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @param Response|null $response
     *
     * @return tags
     */
    public function setResponse(?Response $response): tags
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     *
     * @return tags
     */
    public function setStatus(?int $status): tags
    {
        $this->status = $status;

        return $this;
    }
}
