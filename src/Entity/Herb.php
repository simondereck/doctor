<?php

namespace App\Entity;

use App\Repository\HerbRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HerbRepository::class)
 */
class Herb
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $fid;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $tid;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $cmd;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $hmethod;

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
    private $series;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subSeries;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pinyin;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $latinName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $realPinyin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $realLatin;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $membrum;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $membrumSub;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $realName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $fp;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $franceName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $packageFranceName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $latinLabelName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $latinFtcName;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $law;

    /**
     * @ORM\Column(type="text",nullable=true)
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $fr_price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $jing_price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $baicao_price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cmc;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $old_price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $new_price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $jiangying_price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFid(): ?int
    {
        return $this->fid;
    }

    public function setFid(int $fid): self
    {
        $this->fid = $fid;

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

    public function getCmd(): ?string
    {
        return $this->cmd;
    }

    public function setCmd(string $cmd): self
    {
        $this->cmd = $cmd;

        return $this;
    }

    public function getHmethod(): ?string
    {
        return $this->hmethod;
    }

    public function setHmethod(?string $hmethod): self
    {
        $this->hmethod = $hmethod;

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

    public function setSubSeries(?string $subSeries): self
    {
        $this->subSeries = $subSeries;

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

    public function getLatinName(): ?string
    {
        return $this->latinName;
    }

    public function setLatinName(string $latinName): self
    {
        $this->latinName = $latinName;

        return $this;
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

    public function getRealPinyin(): ?string
    {
        return $this->realPinyin;
    }

    public function setRealPinyin(string $realPinyin): self
    {
        $this->realPinyin = $realPinyin;

        return $this;
    }

    public function getRealLatin(): ?string
    {
        return $this->realLatin;
    }

    public function setRealLatin(?string $realLatin): self
    {
        $this->realLatin = $realLatin;

        return $this;
    }

    public function getMembrum(): ?string
    {
        return $this->membrum;
    }

    public function setMembrum(string $membrum): self
    {
        $this->membrum = $membrum;

        return $this;
    }

    public function getMembrumSub(): ?string
    {
        return $this->membrumSub;
    }

    public function setMembrumSub(string $membrumSub): self
    {
        $this->membrumSub = $membrumSub;

        return $this;
    }

    public function getRealName(): ?string
    {
        return $this->realName;
    }

    public function setRealName(string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getFp(): ?string
    {
        return $this->fp;
    }

    public function setFp(string $fp): self
    {
        $this->fp = $fp;

        return $this;
    }

    public function getFranceName(): ?string
    {
        return $this->franceName;
    }

    public function setFranceName(string $franceName): self
    {
        $this->franceName = $franceName;

        return $this;
    }

    public function getPackageFranceName(): ?string
    {
        return $this->packageFranceName;
    }

    public function setPackageFranceName(string $packageFranceName): self
    {
        $this->packageFranceName = $packageFranceName;

        return $this;
    }

    public function getLatinLabelName(): ?string
    {
        return $this->latinLabelName;
    }

    public function setLatinLabelName(string $latinLabelName): self
    {
        $this->latinLabelName = $latinLabelName;

        return $this;
    }

    public function getLatinFtcName(): ?string
    {
        return $this->latinFtcName;
    }

    public function setLatinFtcName(string $latinFtcName): self
    {
        $this->latinFtcName = $latinFtcName;

        return $this;
    }

    public function getLaw(): ?string
    {
        return $this->law;
    }

    public function setLaw(string $law): self
    {
        $this->law = $law;

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

    public function getUtime(): ?string
    {
        return $this->utime;
    }

    public function setUtime(?string $utime): self
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

    public function getFrPrice(): ?float
    {
        return $this->fr_price;
    }

    public function setFrPrice(?float $fr_price): self
    {
        $this->fr_price = $fr_price;

        return $this;
    }

    public function getJingPrice(): ?float
    {
        return $this->jing_price;
    }

    public function setJingPrice(float $jing_price): self
    {
        $this->jing_price = $jing_price;

        return $this;
    }

    public function getBaicaoPrice(): ?float
    {
        return $this->baicao_price;
    }

    public function setBaicaoPrice(?float $baicao_price): self
    {
        $this->baicao_price = $baicao_price;

        return $this;
    }

    public function getCmc(): ?float
    {
        return $this->cmc;
    }

    public function setCmc(?float $cmc): self
    {
        $this->cmc = $cmc;

        return $this;
    }

    public function getOldPrice(): ?float
    {
        return $this->old_price;
    }

    public function setOldPrice(?float $old_price): self
    {
        $this->old_price = $old_price;

        return $this;
    }

    public function getNewPrice(): ?float
    {
        return $this->new_price;
    }

    public function setNewPrice(?float $new_price): self
    {
        $this->new_price = $new_price;

        return $this;
    }

    public function getJiangyingPrice(): ?float
    {
        return $this->jiangying_price;
    }

    public function setJiangyingPrice(?float $jiangying_price): self
    {
        $this->jiangying_price = $jiangying_price;

        return $this;
    }
}
