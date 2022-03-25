<?php

namespace App\Entity;

use App\Repository\DecaleTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DecaleTypeRepository::class)
 */
class DecaleType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $types;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $utime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ctime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypes(): ?string
    {
        return $this->types;
    }

    public function setTypes(string $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getUtime(): ?string
    {
        return $this->utime;
    }

    public function setUtime(string $utime): self
    {
        $this->utime = $utime;

        return $this;
    }

    public function getCtime(): ?string
    {
        return $this->ctime;
    }

    public function setCtime(string $ctime): self
    {
        $this->ctime = $ctime;

        return $this;
    }
}
