<?php

namespace App\Models\tags;

class Tag
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var int
     */
    private $isActive;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var int
     */
    private $id;


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return Tag
     */
    public function setName(?string $name): Tag
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStoreId(): ?int
    {
        return $this->storeId;
    }

    /**
     * @param int|null $storeId
     *
     * @return Tag
     */
    public function setStoreId(?int $storeId): Tag
    {
        $this->storeId = $storeId;
        
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsActive(): ?int
    {
        return $this->isActive;
    }

    /**
     * @param int|null $isActive
     *
     * @return Tag
     */
    public function setIsActive(?int $isActive): Tag
    {
        $this->isActive = $isActive;
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     *
     * @return Tag
     */
    public function setUpdatedAt(?string $updatedAt): Tag
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     *
     * @return Tag
     */
    public function setCreatedAt(?string $createdAt): Tag
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return Tag
     */
    public function setId(?int $id): Tag
    {
        $this->id = $id;
        
        return $this;
    }
}

