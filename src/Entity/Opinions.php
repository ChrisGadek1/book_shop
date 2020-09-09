<?php

namespace App\Entity;

use App\Repository\OpinionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OpinionsRepository::class)
 */
class Opinions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $ocena;

    /**
     * @ORM\Column(type="text")
     */
    private $opinia;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_dodania;

    /**
     * @ORM\ManyToOne(targetEntity=Books::class, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?users
    {
        return $this->user;
    }

    public function setUser(?users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOcena(): ?int
    {
        return $this->ocena;
    }

    public function setOcena(int $ocena): self
    {
        $this->ocena = $ocena;

        return $this;
    }

    public function getOpinia(): ?string
    {
        return $this->opinia;
    }

    public function setOpinia(string $opinia): self
    {
        $this->opinia = $opinia;

        return $this;
    }

    public function getDataDodania(): ?\DateTimeInterface
    {
        return $this->data_dodania;
    }

    public function setDataDodania(\DateTimeInterface $data_dodania): self
    {
        $this->data_dodania = $data_dodania;

        return $this;
    }

    public function getBook(): ?books
    {
        return $this->book;
    }

    public function setBook(?books $book): self
    {
        $this->book = $book;

        return $this;
    }
}
