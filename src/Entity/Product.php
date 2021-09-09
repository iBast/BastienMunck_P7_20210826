<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * 
 * @Serializer\ExclusionPolicy("all")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $releasedAt;

    /**
     * @ORM\Column(type="text")
     * 
     * @Serializer\Since("1.0")
     * @Serializer\Expose
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Serializer\Since("1.0")
     * @Serialiezr\Expose
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeImmutable $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
