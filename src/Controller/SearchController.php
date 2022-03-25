<?php


namespace App\Controller;


use App\Entity\Herb;
use App\Entity\Medical;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends MainController
{

    /**
     * @Route ("/search/herb")
     * @param Request $request
     * @return Response
     */
    public function findHerb(Request $request):Response{

        $results = [];
        try{
            $keywrods = $request->request->get("keywords");
            $repository = $this->getDoctrine()->getRepository(Herb::class);
            $items = $repository->searchByKeywords($keywrods);
            $results["status"] = 1;
            $results["items"] = $items;
        }catch(\Exception $exception){
            $results["status"] = 0;
        }


        return new Response(json_encode($results));
    }

    /**
     * @Route ("/search/formula")
     * @param Request $request
     * @return Response
     */
    public function findHerbCount(Request $request):Response{
        try{
            $id = $request->request->get("id");

            $repostitory = $this->getDoctrine()->getRepository(Medical::class);
            $items = $repostitory->getOneById($id);

            $ids = [];

            if (count($items)>0){
                $item = $items[0];
//            return new Response(json_encode($item));

                if ($item["formula"]){

                    $jsonObject = json_decode($item["formula"],true);

                    foreach ($jsonObject as $key => $value){
                        $ids[] = $value["id"];
                    }

                    $herbRepostitory = $this->getDoctrine()->getRepository(Herb::class);
                    $herbs = $herbRepostitory->getMedicalsByIds($ids);
                    return new Response(json_encode(["status"=>1,"items"=>$herbs]));

                }

            }
        }catch(\Exception $exception){
            return new Response(json_encode(["status"=>0]));

        }
        return new Response(json_encode(["status"=>0]));

    }
}