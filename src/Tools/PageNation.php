<?php


namespace App\Tools;


class PageNation
{
    private $page = 0;
    private $limit = 10;
    private $total = 0;
    private $offset = 0;
    private $totalPage = 0;
    private $baseUrl = "";

    private $pages = [];
    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }


    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }


    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }


    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }




    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function caculate(){

    }

    public function getOffset(){
        $this->offset = $this->page * $this->limit;
        return $this->offset;
    }

    public function getTotalPage():int
    {
        $this->totalPage =  ceil($this->total / $this->limit);
        return $this->totalPage;
    }

    public function getPages():array
    {
        $this->pages = [];
        if ($this->getTotalPage()>0){
            if ($this->page>1){
                $this->pages[] = new PageItem(-1,"<<",$this->baseUrl."?page=".($this->page-1));
            }
            if ($this->getTotalPage()<=12){
                for ($i = 0; $i < $this->totalPage; $i++) {
                    $this->pages[] = new PageItem($i,($i+1)."",$this->baseUrl."?page=".$i);
                }
            }else{
                for ($i = 0; $i<12;$i++){
                    if ($this->page>6){
                        if ($i==0){
                            $this->pages[] = new PageItem(0,($i+1)."...",$this->baseUrl."?page=0");
                        }
                        if ($this->page+12>$this->totalPage){
                            $this->pages[] = new PageItem($this->totalPage-12+$i,($this->totalPage-11+$i)."",$this->baseUrl."?page=".($this->totalPage-12+$i));
                        }else{
                            $this->pages[] = new PageItem($this->page-7+$i,($this->page-6+$i)."",$this->baseUrl."?page=".($this->page-7+$i));
                        }
                        if ($i==11){
                            $this->pages[] = new PageItem($this->totalPage-1,"..." . ($this->totalPage),$this->baseUrl."?page=".($this->totalPage-1));
                        }
                    }else{
                        if ($i==0){
                            $this->pages[] = new PageItem(0,($i+1)."...",$this->baseUrl."?page=0");
                        }
                        $this->pages[] = (new PageItem($i,($i+1)."",$this->baseUrl."?page=".$i));

                        if ($i==11){
                            $this->pages[] = new PageItem($this->totalPage-1,"..." . ($this->totalPage),$this->baseUrl."?page=".($this->totalPage-1));
                        }
                    }

                }
            }


            if ($this->page<$this->totalPage-1){
                $this->pages[] = new PageItem(-1,">>",$this->baseUrl."?page=".($this->page+1));
            }
        }
        return $this->pages;
    }

}