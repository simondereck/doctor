<?php

namespace App\Controller;

use App\Entity\Herb;
use App\Form\HerbFormType;
use App\Form\HerbUpdateFormType;
use App\Tools\PageNation;
use App\Tools\SMTools;
use Doctrine\Common\Collections\Criteria;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

class HerbController extends MainController
{
    /**
     * @Route("/herb/lists", name="herb")
     */
    public function index(Request $request): Response
    {

        $params = $searchParams = [];
        $tid = $request->request->get("tid");
        $category = $request->request->get("category");
        $cc = $request->request->get("cc");
        $series = $request->request->get("series");
        $subSeries = $request->request->get("subSeries");
        $name = $request->request->get("name");
        $pinyin = $request->request->get("pinyin");
        $latinName = $request->request->get("latinName");
        $order = $request->request->get("order",0);

        if ($tid){
            $params["tid"] = $tid;
            $searchParams[] = ["key"=>"tid","value"=>$tid,"like"=>false];
        }


        if ($category){
            $params["category"] = $category;
            $searchParams[] = ["key"=>"category","value"=>$category,"like"=>true];
        }

        if ($cc){
            $params["cc"] = $cc;
            $searchParams["cc like "] = "%".$cc."%";
            $searchParams[] = ["key"=>"cc","value"=>$cc,"like"=>true];
        }
        if ($series){
            $params["series"] = $series;
            $searchParams[] = ["key"=>"series","value"=>$series,"like"=>true];

        }
        if ($subSeries){
            $params["subSeries"] = $subSeries;
            $searchParams[] = ["key"=>"subSeries","value"=>$subSeries,"like"=>true];

        }

        if ($name){
            $params["name"] = $name;
            $searchParams[] = ["key"=>"name","value"=>$name,"like"=>true];
        }

        if ($pinyin){
            $params["pinyin"] = $pinyin;
            $searchParams[] = ["key"=>"pinyin","value"=>$pinyin,"like"=>true];


        }

        if ($latinName){
            $params["latinName"] = $latinName;
            $searchParams[] = ["key"=>"latinName","value"=>$latinName,"like"=>true];
        }



        $repository = $this->getDoctrine()->getRepository(Herb::class);
        $count = $repository->countSearch($searchParams);


        $page = $request->query->get("page",0);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setBaseUrl("/herb/lists");

        $pageNation->setPage($page);
        $items = $repository->paramsSearch($searchParams,$pageNation->getLimit(),$pageNation->getOffset(),$order);

        return $this->render('herb/index.html.twig', [
            'items'=>$items,
            'pages'=>$pageNation->getPages(),
            'currentPage'=>$pageNation->getPage(),
            'params'=>$params,
            'order'=>$order
        ]);

    }


    /**
     * @param Request $request
     * @Route ("/herb/detail")
     */
    public function herbDetail(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repository = $this->getDoctrine()->getRepository(Herb::class);
            $herb = $repository->findOneById($id);
            if ($herb){
                return $this->render("herb/herb.detail.html.twig",[
                    "herb"=>$herb
                ]);
            }
            return $this->error("没有找到对应的条目");
        }

        return $this->error("请提供正确的id");


    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/herb/create")
     */

    public function createHerb(Request $request):Response
    {
        $herb = new Herb();
        $form = $this->createForm(HerbFormType::class,$herb);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            //save form data
            $herb->setUtime(SMTools::getDateString());
            $herb->setCtime(SMTools::getDateString());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($herb);
            $entityManager->flush();
            return $this->redirect("/herb/lists");

        }

        return $this->render("herb/herb.create.html.twig",[
            "herb_form"=>$form->createView()
        ]);

    }


    /**
     * @Route ("/herb/update")
     */
    public function updateHerb(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repository = $this->getDoctrine()->getRepository(Herb::class);
            $herb = $repository->findOneById($id);
            $form = $this->createForm(HerbUpdateFormType::class,$herb);
            if ($form->isSubmitted()&&$form->isValid()){

            }
            if ($herb){
                return $this->render("herb/herb.update.html.twig",[
                    "herb_form"=>$form->createView()
                ]);
            }
            return $this->error("没有找到对应的条目");

        }

        return $this->error("请提供正确的id");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/herb/delete")
     */
    public function herbDelete(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repository = $this->getDoctrine()->getRepository(Herb::class);
            $herb = $repository->findOneById($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($herb);
            $entityManager->flush();
            return $this->redirect("/herb/lists");
        }

        return $this->error("请提供正确的id");
    }


//    public $publicDirectory = '/Library/WebServer/Documents/symfony/doctor/public/download';
    public $publicDirectory = '/usr/share/nginx/html/doctor/public/download';

    /**
     * @Route ("/herb/download")
     * @param Request $request
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function downloadHerbs(Request $request):Response{
        $params = $searchParams = [];
        $tid = $request->request->get("tid");
        $category = $request->request->get("category");
        $cc = $request->request->get("cc");
        $series = $request->request->get("series");
        $subSeries = $request->request->get("subSeries");
        $name = $request->request->get("name");
        $pinyin = $request->request->get("pinyin");
        $latinName = $request->request->get("latinName");
        $order = $request->request->get("order",0);
        $title = "";

        if ($tid){
            $params["tid"] = $tid;
            $searchParams[] = ["key"=>"tid","value"=>$tid,"like"=>false];
            $title .= $tid."--";

        }


        if ($category){
            $params["category"] = $category;
            $searchParams[] = ["key"=>"category","value"=>$category,"like"=>true];
            $title .= $category."--";

        }

        if ($cc){
            $params["cc"] = $cc;
            $searchParams[] = ["key"=>"cc","value"=>$cc,"like"=>true];
            $title .= $cc."--";

        }
        if ($series){
            $params["series"] = $series;
            $searchParams[] = ["key"=>"series","value"=>$series,"like"=>true];
            $title .= $series."--";


        }

        if ($subSeries){
            $params["subSeries"] = $subSeries;
            $searchParams[] = ["key"=>"subSeries","value"=>$subSeries,"like"=>true];
            $title .= $subSeries."--";
        }

        if ($name){
            $params["name"] = $name;
            $searchParams[] = ["key"=>"name","value"=>$name,"like"=>true];
            $title .= $name."--";
        }

        if ($pinyin){
            $params["pinyin"] = $pinyin;
            $searchParams[] = ["key"=>"pinyin","value"=>$pinyin,"like"=>true];
            $title .= $pinyin."--";
        }

        if ($latinName){
            $params["latinName"] = $latinName;
            $searchParams[] = ["key"=>"latinName","value"=>$latinName,"like"=>true];
            $title .= $latinName."--";
        }



        $repository = $this->getDoctrine()->getRepository(Herb::class);
        $count = $repository->countSearch($searchParams);


        $page = $request->query->get("page",0);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setBaseUrl("/herb/lists");

        $pageNation->setPage($page);
        $items = $repository->paramsSearch($searchParams,[],[]);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("草药");
        $sheet->setCellValueByColumnAndRow(1, 1,"id");
        $sheet->setCellValueByColumnAndRow(2, 1,"tid");
        $sheet->setCellValueByColumnAndRow(3, 1,"fid" );
        $sheet->setCellValueByColumnAndRow(4, 1,"series" );
        $sheet->setCellValueByColumnAndRow(5, 1,"subSeries");
        $sheet->setCellValueByColumnAndRow(6, 1,"pinyin");
        $sheet->setCellValueByColumnAndRow(7, 1,"name" );
        $sheet->setCellValueByColumnAndRow(8, 1,"latinName");
        $sheet->setCellValueByColumnAndRow(9, 1,"franceName" );
        $sheet->setCellValueByColumnAndRow(10, 1,"realPinyin");
        $sheet->setCellValueByColumnAndRow(11, 1,"realName");
        $sheet->setCellValueByColumnAndRow(12, 1,"realLatin");
        $sheet->setCellValueByColumnAndRow(13, 1,"detail1");
        $sheet->setCellValueByColumnAndRow(14, 1,"detail2" );
        $sheet->setCellValueByColumnAndRow(15, 1,"category" );
        $sheet->setCellValueByColumnAndRow(16, 1,"cc");
        $sheet->setCellValueByColumnAndRow(17, 1,"fp");
        $sheet->setCellValueByColumnAndRow(18, 1,"membrum");
        $sheet->setCellValueByColumnAndRow(19, 1,"packageFranceName" );
        $sheet->setCellValueByColumnAndRow(20, 1,"latinLabelName");
        $sheet->setCellValueByColumnAndRow(21, 1,"latinFtcName" );
        $sheet->setCellValueByColumnAndRow(22, 1,"law");
        $sheet->setCellValueByColumnAndRow(23, 1,"description");
        $sheet->setCellValueByColumnAndRow(24, 1,"法进价" );
        $sheet->setCellValueByColumnAndRow(25, 1,"江阴价" );
        $sheet->setCellValueByColumnAndRow(26, 1,"仲景堂" );
        $sheet->setCellValueByColumnAndRow(27, 1,"百草" );
        $sheet->setCellValueByColumnAndRow(28, 1,"cmc" );
        $sheet->setCellValueByColumnAndRow(29, 1,"旧批发价	" );
        $sheet->setCellValueByColumnAndRow(30, 1,"新批发价" );
        for ($i=0;$i<count($items);$i++){
            $sheet->setCellValueByColumnAndRow(1, $i+2,$items[$i]["id"] );
            $sheet->setCellValueByColumnAndRow(2, $i+2,$items[$i]["tid"] );
            $sheet->setCellValueByColumnAndRow(3, $i+2,$items[$i]["fid"] );
            $sheet->setCellValueByColumnAndRow(4, $i+2,$items[$i]["series"] );
            $sheet->setCellValueByColumnAndRow(5, $i+2,$items[$i]["subSeries"]);
            $sheet->setCellValueByColumnAndRow(6, $i+2,$items[$i]["pinyin"] );
            $sheet->setCellValueByColumnAndRow(7, $i+2,$items[$i]["name"] );
            $sheet->setCellValueByColumnAndRow(8, $i+2,$items[$i]["latinName"] );
            $sheet->setCellValueByColumnAndRow(9, $i+2,$items[$i]["franceName"] );
            $sheet->setCellValueByColumnAndRow(10, $i+2,$items[$i]["realPinyin"] );
            $sheet->setCellValueByColumnAndRow(11, $i+2,$items[$i]["realName"] );
            $sheet->setCellValueByColumnAndRow(12, $i+2,$items[$i]["realLatin"] );
            $sheet->setCellValueByColumnAndRow(13, $i+2,$items[$i]["cmd"]);
            $sheet->setCellValueByColumnAndRow(14, $i+2,$items[$i]["hmethod"] );
            $sheet->setCellValueByColumnAndRow(15, $i+2,$items[$i]["category"] );
            $sheet->setCellValueByColumnAndRow(16, $i+2,$items[$i]["cc"]);
            $sheet->setCellValueByColumnAndRow(17, $i+2,$items[$i]["fp"] );
            $sheet->setCellValueByColumnAndRow(18, $i+2,$items[$i]["membrum"] );
            $sheet->setCellValueByColumnAndRow(19, $i+2,$items[$i]["packageFranceName"] );
            $sheet->setCellValueByColumnAndRow(20, $i+2,$items[$i]["latinLabelName"]);
            $sheet->setCellValueByColumnAndRow(21, $i+2,$items[$i]["latinFtcName"] );
            $sheet->setCellValueByColumnAndRow(22, $i+2,$items[$i]["law"]);
            $sheet->setCellValueByColumnAndRow(23, $i+2,$items[$i]["description"]);
            $sheet->setCellValueByColumnAndRow(24, $i+2,$items[$i]["fr_price"] );
            $sheet->setCellValueByColumnAndRow(25, $i+2,$items[$i]["jiangying_price"] );
            $sheet->setCellValueByColumnAndRow(26, $i+2,$items[$i]["jing_price"] );
            $sheet->setCellValueByColumnAndRow(27, $i+2,$items[$i]["baicao_price"] );
            $sheet->setCellValueByColumnAndRow(28, $i+2,$items[$i]["cmc"] );
            $sheet->setCellValueByColumnAndRow(29, $i+2,$items[$i]["old_price"] );
            $sheet->setCellValueByColumnAndRow(30, $i+2,$items[$i]["new_price"] );
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $title.SMTools::getDateString().'-原料.xlsx';
        $excelFilepath =  $this->publicDirectory .'/'.$filename;

        $writer->save($excelFilepath);

        return $this->render("download.html.twig",[
            'filename'=>$filename
        ]);

    }
}
