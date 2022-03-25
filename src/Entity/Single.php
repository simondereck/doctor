<?php

namespace App\Entity;

use App\Repository\SingleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SingleRepository::class)
 */
class Single
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $series;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subSeries;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $declare_no;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ean;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lot;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pinyin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etiquette;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $use_as;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shop;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $utime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ctime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latin_real;

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

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(?string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getSubSeries(): ?string
    {
        return $this->subSeries;
    }

    public function setSubSeries(string $subSeries): self
    {
        $this->subSeries = $subSeries;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCc(): ?string
    {
        return $this->cc;
    }

    public function setCc(?string $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function getTid(): ?string
    {
        return $this->tid;
    }

    public function setTid(?string $tid): self
    {
        $this->tid = $tid;

        return $this;
    }

    public function getDeclareNo(): ?string
    {
        return $this->declare_no;
    }

    public function setDeclareNo(?string $declare_no): self
    {
        $this->declare_no = $declare_no;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(?string $ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    public function getLot(): ?string
    {
        return $this->lot;
    }

    public function setLot(?string $lot): self
    {
        $this->lot = $lot;

        return $this;
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

    public function getLatin(): ?string
    {
        return $this->latin;
    }

    public function setLatin(?string $latin): self
    {
        $this->latin = $latin;

        return $this;
    }

    public function getPinyin(): ?string
    {
        return $this->pinyin;
    }

    public function setPinyin(?string $pinyin): self
    {
        $this->pinyin = $pinyin;

        return $this;
    }

    public function getEtiquette(): ?string
    {
        return $this->etiquette;
    }

    public function setEtiquette(?string $etiquette): self
    {
        $this->etiquette = $etiquette;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getUseAs(): ?string
    {
        return $this->use_as;
    }

    public function setUseAs(?string $use_as): self
    {
        $this->use_as = $use_as;

        return $this;
    }

    public function getShop(): ?string
    {
        return $this->shop;
    }

    public function setShop(?string $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function setCtime(?string $ctime): self
    {
        $this->ctime = $ctime;

        return $this;
    }

    public function getLatinReal(): ?string
    {
        return $this->latin_real;
    }

    public function setLatinReal(?string $latin_real): self
    {
        $this->latin_real = $latin_real;

        return $this;
    }
}
