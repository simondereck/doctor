<?php

namespace App\Entity;

use App\Repository\MedicalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicalRepository::class)
 */
class Medical
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $useAs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cc;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $tid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $declareNo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ean;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceInternal;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceCp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $priceGl;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceShop;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceInterGl;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceInterCp;

    /**
     * @ORM\Column(type="integer")
     */
    private $shop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pinyin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chinese;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $formula;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $des2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cle1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cle2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cle3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cle4;

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

    public function getUseAs(): ?string
    {
        return $this->useAs;
    }

    public function setUseAs(?string $useAs): self
    {
        $this->useAs = $useAs;

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
        return $this->declareNo;
    }

    public function setDeclareNo(?string $declareNo): self
    {
        $this->declareNo = $declareNo;

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

    public function getPriceInternal(): ?float
    {
        return $this->priceInternal;
    }

    public function setPriceInternal(?float $priceInternal): self
    {
        $this->priceInternal = $priceInternal;

        return $this;
    }

    public function getPriceCp(): ?float
    {
        return $this->priceCp;
    }

    public function setPriceCp(?float $priceCp): self
    {
        $this->priceCp = $priceCp;

        return $this;
    }

    public function getPriceGl(): ?string
    {
        return $this->priceGl;
    }

    public function setPriceGl(?string $priceGl): self
    {
        $this->priceGl = $priceGl;

        return $this;
    }

    public function getPriceShop(): ?float
    {
        return $this->priceShop;
    }

    public function setPriceShop(?float $priceShop): self
    {
        $this->priceShop = $priceShop;

        return $this;
    }

    public function getPriceInterGl(): ?float
    {
        return $this->priceInterGl;
    }

    public function setPriceInterGl(?float $priceInterGl): self
    {
        $this->priceInterGl = $priceInterGl;

        return $this;
    }

    public function getPriceInterCp(): ?float
    {
        return $this->priceInterCp;
    }

    public function setPriceInterCp(?float $priceInterCp): self
    {
        $this->priceInterCp = $priceInterCp;

        return $this;
    }

    public function getShop(): ?int
    {
        return $this->shop;
    }

    public function setShop(int $shop): self
    {
        $this->shop = $shop;

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

    public function getChinese(): ?string
    {
        return $this->chinese;
    }

    public function setChinese(?string $chinese): self
    {
        $this->chinese = $chinese;

        return $this;
    }

    public function getFormula(): ?string
    {
        return $this->formula;
    }

    public function setFormula(?string $formula): self
    {
        $this->formula = $formula;

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

    public function setCtime(string $ctime): self
    {
        $this->ctime = $ctime;

        return $this;
    }

    public function getDes2(): ?string
    {
        return $this->des2;
    }

    public function setDes2(?string $des2): self
    {
        $this->des2 = $des2;

        return $this;
    }

    public function getCle1(): ?string
    {
        return $this->cle1;
    }

    public function setCle1(?string $cle1): self
    {
        $this->cle1 = $cle1;

        return $this;
    }

    public function getCle2(): ?string
    {
        return $this->cle2;
    }

    public function setCle2(?string $cle2): self
    {
        $this->cle2 = $cle2;

        return $this;
    }

    public function getCle3(): ?string
    {
        return $this->cle3;
    }

    public function setCle3(?string $cle3): self
    {
        $this->cle3 = $cle3;

        return $this;
    }

    public function getCle4(): ?string
    {
        return $this->cle4;
    }

    public function setCle4(?string $cle4): self
    {
        $this->cle4 = $cle4;

        return $this;
    }
}
