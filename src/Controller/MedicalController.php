<?php

namespace App\Controller;

use App\Entity\DecaleType;
use App\Entity\Herb;
use App\Entity\Medical;
use App\Entity\Single;
use App\Form\MedicalFormType;
use App\Form\MedicalUpdateFormType;
use App\Form\SingleFormType;
use App\Form\SingleUpdateFormType;
use App\Repository\HerbRepository;
use App\Tools\PageNation;
use App\Tools\SMTools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicalController extends MainController
{
    /**
     * @Route("/medical", name="medical")
     */
    public function index(Request $request): Response
    {

        $page = $request->query->get("page",0);

        $type = $request->request->get("type");
        $series = $request->request->get("series");
        $category = $request->request->get("category");
        $tid = $request->request->get("tid","");
        $chinese = $request->request->get("chinese","");
        $pinyin = $request->request->get("pinyin","");
        $order = $request->request->get("order",0);

        $repostitory = $this->getDoctrine()->getRepository(Medical::class);
        $params = [];
        $searchParams = [];
        if ($type){
            $params["type"] = $type;
            $searchParams[] = ["key"=>"type","value"=>$type,"like"=>false];

        }

        if ($series){
            $params["series"] = $series;
            $searchParams[] = ["key"=>"series","value"=>$series,"like"=>true];
        }

        if ($category){
            $params["category"] = $category;
            $searchParams[] = ["key"=>"category","value"=>$category,"like"=>true];

        }

        if($tid){
            $params["tid"] = $tid;
            $searchParams[] = ["key"=>"tid","value"=>$tid,"like"=>false];

        }

        if($chinese){
            $params["chinese"] = $chinese;
            $searchParams[] = ["key"=>"chinese","value"=>$chinese,"like"=>true];
        }

        if($pinyin){
            $params["pinyin"] = $pinyin;
            $searchParams[] = ["key"=>"pinyin","value"=>$pinyin,"like"=>true];
        }


        $count = $repostitory->countSearch($searchParams);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setPage($page);
        $pageNation->setBaseUrl("/medical");
        $items = $repostitory->paramsSearch($searchParams,$pageNation->getLimit(),$pageNation->getOffset(),$order);


        return $this->render('medical/index.html.twig', [
            'items' => $items,
            'pages' => $pageNation->getPages(),
            'currentPage' => $pageNation->getPage(),
            'params'=>$params,
            'order'=>$order
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/medical/detail")
     */
    public function medicalDetail(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Medical::class);
            $item = $repostitory->findOneById($id);
            if ($item){
                return $this->render("medical/medical.detail.html.twig",[
                    "item"=>$item
                ]);
            }
            return $this->error("找不到相关条目");
        }
        return $this->error("请提供正确的id");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/medical/create")
     */
    public function createMedical(Request $request):Response
    {
        $medical = new Medical();
        $form = $this->createForm(MedicalFormType::class,$medical);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $medical->setUtime(SMTools::getDateString());
            $medical->setCtime(SMTools::getDateString());
            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($medical);
            $entityManger->flush();
            return $this->redirect("/medical");
        }

        return $this->render("medical/medical.create.html.twig",[
            "medical_form"=>$form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/medical/update")
     */
    public function updateMedical(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Medical::class);
            $item = $repostitory->findOneById($id);
            if ($item){
                $form = $this->createForm(MedicalUpdateFormType::class,$item);
                $form->handleRequest($request);

                if ($form->isSubmitted()&&$form->isValid()){
                    $item->setUtime(SMTools::getDateString());
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($item);
                    $entityManager->flush();
                    return $this->redirect("/medical");
                }

                return $this->render("medical/medical.update.html.twig",[
                    "medical_form"=>$form->createView(),
                    "id"=>$id
                ]);
            }
        }
        return $this->error("请提供正确的🆔");



    }

    /**
     * @Route ("/medical/delete")
     * @param Request $request
     * @return Response
     */
    public function deleteMedical(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0) {
            $repostitory = $this->getDoctrine()->getRepository(Medical::class);
            $item = $repostitory->findOneById($id);
            if ($item){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($item);
                $entityManager->flush();
                return $this->redirect("/medical");

            }
            return $this->error("没有对应的条目");

        }
        return $this->error("请提供正确的id");

    }

    /**
     * @Route ("/medical/formula")
     * @param Request $request
     * @return Response
     */
    public function formula(Request $request):Response
    {
        $id = $request->query->get("id",0);
        $total = $request->request->get("total",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Medical::class);
            $item = $repostitory->findOneById($id);
            if ($item){
                $json = json_decode($item->getFormula(),true);
                $ids = [];
                foreach ($json as $key=>$val){
                    $ids[] = $val["id"];
                }
                $herbRepostitory = $this->getDoctrine()->getRepository(Herb::class);
                $herbs = $herbRepostitory->getMedicalsByIds($ids);
                foreach ($json as $jk=>$jv){
                    foreach ($herbs as $hkey => $herb){
                        if ($herb["id"]==$jv["id"]){
                            $json[$jk]["item"] = $herb;
                        }
                    }
                }

                return $this->render("medical/formula.html.twig",["item"=>$item,"json"=>$json,"total_count"=>0,"total"=>$total]);
            }
        }
        return $this->error("请提供正确的id");

    }


    /**
     * @Route ("/medical/single")
     * @param Request $request
     * @return Response
     */
    public function singleLists(Request $request):Response{
        $page = $request->query->get("page",0);

        $params = [];
        $searchParams = [];
        $name = $request->request->get("name");
        $series = $request->request->get("series");
        $category = $request->request->get("category");
        $cc = $request->request->get("cc");
        $tid = $request->request->get("tid");
        $order = $request->request->get("order",0);

        if ($name){
            $params["name"] = $name;
            $searchParams[] = ["key"=>"name","value"=>$name,"like"=>true];
        }

        if ($series){
            $params["series"] = $series;
            $searchParams[] = ["key"=>"series","value"=>$series,"like"=>true];
        }

        if ($category){
            $params["category"] = $category;
            $searchParams[] = ["key"=>"category","value"=>$category,"like"=>true];
        }

        if ($cc){
            $params["cc"] = $cc;
            $searchParams[] = ["key"=>"cc","value"=>$cc,"like"=>true];
        }

        if ($tid){
            $params["tid"] = $tid;
            $searchParams[] = ["key"=>"tid","value"=>$tid,"like"=>false];
        }

        $repostitory = $this->getDoctrine()->getRepository(Single::class);
        $count = $repostitory->countSearch($searchParams);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setPage($page);
        $pageNation->setBaseUrl("/medical/single");
        $items = $repostitory->paramsSearch($searchParams,$pageNation->getLimit(),$pageNation->getOffset(),$order);


        return $this->render('medical/single.lists.html.twig', [
            'items' => $items,
            'pages' => $pageNation->getPages(),
            'currentPage' => $pageNation->getPage(),
            'params'=>$params,
            'order'=>$order
        ]);

    }

    /**
     * @Route ("/medical/single/create")
     * @param Request $request
     * @return Response
     */
    public function singleCreate(Request $request):Response{
        $single = new Single();
        $form = $this->createForm(SingleFormType::class,$single);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $single->setType(4);
            $single->setUtime(SMTools::getDateString());
            $single->setCtime(SMTools::getDateString());
            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($single);
            $entityManger->flush();
            return $this->redirect("/medical/single");
        }

        return $this->render('medical/single.create.html.twig',[
            "single_form"=>$form->createView()
        ]);

    }

    /**
     * @Route ("/medical/single/delete")
     * @param Request $request
     * @return Response
     */
    public function singleDelete(Request $request):Response{

        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Single::class);
            $item = $repostitory->findOneById($id);
            if ($item){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($item);
                $entityManager->flush();
                return $this->redirect("/medical/single");
            }
            return $this->error("没有对应的条目");
        }
        return $this->error("请提供正确的id");

    }


    /**
     * @Route ("/medical/single/detail")
     * @param Request $request
     * @return Response
     */
    public function singleDetail(Request $request):Response{
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Single::class);
            $item = $repostitory->findOneById($id);
            if ($item){
                return $this->render("medical/single.detail.html.twig",[
                    "item"=>$item
                ]);
            }
            return $this->error("找不到相关条目");
        }
        return $this->error("请提供正确的id");

    }

    /**
     * @Route ("/medical/single/update")
     * @param Request $request
     * @return Response
     */
    public function singleUpdate(Request $request):Response{

        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Single::class);
            $item = $repostitory->findOneById($id);
            if ($item){
                $form = $this->createForm(SingleUpdateFormType::class,$item);
                $form->handleRequest($request);

                if ($form->isSubmitted()&&$form->isValid()){
                    $item->setUtime(SMTools::getDateString());
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($item);
                    $entityManager->flush();
                    return $this->redirect("/medical");
                }

                return $this->render("medical/single.update.html.twig",[
                    "medical_form"=>$form->createView(),
                    "id"=>$id
                ]);
            }
        }
        return $this->error("请提供正确的🆔");

    }


}
