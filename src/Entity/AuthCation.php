<?php


namespace App\Entity;


class AuthCation
{

    public $error;

    public function generatePassword():string
    {
        return md5(md5($this->getPassword())."_calebasse");
    }


}