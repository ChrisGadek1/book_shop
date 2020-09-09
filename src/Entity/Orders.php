<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_client;

    /**
     * @ORM\ManyToOne(targetEntity=Books::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_book;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?users
    {
        return $this->id_client;
    }

    public function setIdClient(?users $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getIdBook(): ?books
    {
        return $this->id_book;
    }

    public function setIdBook(?books $id_book): self
    {
        $this->id_book = $id_book;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
