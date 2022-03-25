<?php


namespace App\Tools;


class PageItem
{
    private $key;
    private $url;
    private $postion;

    public function __construct(int $postion,String $key,String $url)
    {
        $this->key = $key;
        $this->url = $url;
        $this->postion = $postion;
    }


    public function setPostion(int $postion): void
    {
        $this->postion = $postion;
    }
    public function setKey(String $key){
        $this->key = $key;
    }

    public function setUrl(String $url){
        $this->url = $url;
    }

    public function getKey():string
    {
        return $this->key;
    }

    public function getUrl():string
    {
        return $this->url;
    }

    public function getPostion(): int
    {
        return $this->postion;
    }
}