<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Interfaces\ToArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Asserts;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\ProductRepository")
 * @ORM\Table(name="products")
 * @UniqueEntity({"code"})
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Наименование товара.
     *
     * @var string
     * @ORM\Column(type="string")
     * @Asserts\NotBlank()
     */
    private $title;

    /**
     * Артикул.
     *
     * @var string
     * @ORM\Column(type="string", unique=true)
     * @Asserts\NotBlank()
     */
    private $code;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title = null): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->title;
    }

    public function setCode(string $code = null): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return (string)$this->code;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'code' => $this->code
        ];
    }
}
