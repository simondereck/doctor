<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StoreRepository::class)
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cdate;

    /**
     * @ORM\Column(type="float")
     */
    private $data;

    /**
     * @ORM\Column(type="integer")
     */
    private $stype;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $utime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ctime;

    /**
     * @ORM\Column(type="integer")
     */
    private $tid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCdate(): ?string
    {
        return $this->cdate;
    }

    public function setCdate(string $cdate): self
    {
        $this->cdate = $cdate;

        return $this;
    }

    public function getData(): ?float
    {
        return $this->data;
    }

    public function setData(float $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getStype(): ?int
    {
        return $this->stype;
    }

    public function setStype(int $stype): self
    {
        $this->stype = $stype;

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

    public function getTid(): ?int
    {
        return $this->tid;
    }

    public function setTid(int $tid): self
    {
        $this->tid = $tid;

        return $this;
    }
}
