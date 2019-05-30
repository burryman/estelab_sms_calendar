<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntriesRepository")
 */
class Entries
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entryDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shortUrlCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $entryId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(?\DateTimeInterface $entryDate): self
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function getShortUrlCode(): ?string
    {
        return $this->shortUrlCode;
    }

    public function setShortUrlCode(?string $shortUrlCode): self
    {
        $this->shortUrlCode = $shortUrlCode;

        return $this;
    }

    public function getEntryId(): ?int
    {
        return $this->entryId;
    }

    public function setEntryId(?int $entryId): self
    {
        $this->entryId = $entryId;

        return $this;
    }
}
