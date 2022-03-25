<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Upload
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
     * @ORM\Column(type="string")
     */
    private $file;

    public function getId(){
        return $this->id;
    }


    public function getType(){
        return $this->type;
    }


    public function setType($type){
        $this->type = $type;
        return $this;
    }


    public function getFile(){
        return $this->file;
    }


    public function setFile($file){
        $this->file = $file;
        return $this;
    }

}
