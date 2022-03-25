<?php


namespace App\Controller;


use App\Entity\Admin;
use App\Entity\Herb;
use App\Entity\Medical;
use App\Entity\Single;
use App\Entity\Upload;
use App\Form\StoreFormType;
use App\Form\UploadFormType;
use App\Tools\SMTools;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\PageNation;
use App\Entity\Store;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

class StoreController extends MainController
{


//    public $uploadPath = "/Library/WebServer/Documents/symfony/doctor/public/upload/";
//    public $publicDirectory = '/Library/WebServer/Documents/symfony/doctor/public/download';
    public $uploadPath = "/usr/share/nginx/html/doctor/public/upload/";
    public $publicDirectory = '/usr/share/nginx/html/doctor/public/download';


    /**
     * @Route ("/store/index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request):Response{
        $page = $request->query->get("page",0);
        $repostitory = $this->getDoctrine()->getRepository(Medical::class);

        $type = $request->request->get("type",0);
        $series = $request->request->get("series","");
        $category = $request->request->get("category","");
        $tid = $request->request->get("tid","");

        $params = [];
        if ($type){
            $params["type"] = $type;
        }

        if ($series){
            $params["series"] = $series;
        }

        if ($category){
            $params["category"] = $category;
        }

        if($tid){
            $params["tid"] = $tid;
        }

        $count = $repostitory->count($params);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setPage($page);
        $pageNation->setBaseUrl("/store/index");
        $items = $repostitory->findBy($params,[],$pageNation->getLimit(),$pageNation->getOffset());

        $stores = [];
//        {"name": "type", "label": "类型 胶囊1 浓缩粉2 复方小药包3 单味产品4 原材料5", "type": "int"},

        if ($items){
            foreach($items as $key=>$item){
                $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
                $stores[$key]["store"] = $storeRepostitory->findResultsByIdsAndDate($item->getId(),$item->getType());
                $stores[$key]["item"] = $item;
            }

        }

        return $this->render('store/index.html.twig',[
            'items' => $items,
            'pages' => $pageNation->getPages(),
            'currentPage' => $pageNation->getPage(),
            'stores'=>$stores,
            'params'=>$params
        ]);


    }

    /**
     * @Route ("/store/herb")
     * @param Request $request
     * @return Response
     */
    public function herb(Request $request):Response{
        $repository = $this->getDoctrine()->getRepository(Herb::class);
        $params = [];

        $id = $request->request->get("id");
        $tid = $request->request->get("tid");
        $series = $request->request->get("series");
        $subSeries = $request->request->get("subSeries");
        $name = $request->request->get("name");

        if ($id){
            $params["id"] = $id;
        }

        if ($tid){
            $params["tid"] = $tid;
        }



        if ($series){
            $params["series"] = $series;
        }


        if ($subSeries){
            $params["subSeries"] = $subSeries;
        }

        if ($name){
            $params["name"] = $name;
        }

        $count = $repository->count($params);

        $page = $request->query->get("page",0);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setBaseUrl("/store/herb");

        $pageNation->setPage($page);

        $items = $repository->findBy($params,[],$pageNation->getLimit(),$pageNation->getOffset());

        $stores = [];
        if ($items){
            foreach($items as $key=>$item){
                $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
                // --- caoyao
                $stores[$key]["store"] = $storeRepostitory->findResultsByIdsAndDate($item->getId(),5);
                $stores[$key]["item"] = $item;
            }

        }


        return $this->render('store/herb.html.twig', [
            'items'=>$items,
            'pages'=>$pageNation->getPages(),
            'currentPage'=>$pageNation->getPage(),
            'params'=>$params,
            'stores'=>$stores
        ]);

    }


    /**
     * @Route ("/store/single")
     * @param Request $request
     * @return Request
     */
    public function single(Request $request):Response{

        $page = $request->query->get("page",0);
        $repostitory = $this->getDoctrine()->getRepository(Single::class);

        $params = [];
        $tid = $request->request->get("tid");
        $series = $request->request->get("series");
        $name = $request->request->get("name");
        $category = $request->request->get("category");
        $cc = $request->request->get("cc");

        if ($tid){
            $params["tid"] = $tid;
        }
        if ($series){
            $params["series"] = $series;
        }
        if ($name){
            $params["name"] = $name;
        }

        if ($category){
            $params["category"] = $category;
        }
        if ($cc){
            $params["cc"] = $cc;
        }

        $count = $repostitory->count($params);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setPage($page);
        $pageNation->setBaseUrl("/store/single");
        $items = $repostitory->findBy($params,[],$pageNation->getLimit(),$pageNation->getOffset());
        $stores = [];
        if ($items){
            foreach($items as $key=>$item){
                $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
                $stores[$key]["store"] = $storeRepostitory->findResultsByIdsAndDate($item->getId(),$item->getType());
                $stores[$key]["item"] = $item;
            }
        }

        return $this->render('store/single.html.twig', [
            'items' => $items,
            'pages' => $pageNation->getPages(),
            'currentPage' => $pageNation->getPage(),
            'params'=>$params,
            'stores'=>$stores
        ]);
    }


    /**
     * @Route ("/store/single/download")
     * @param Request $request
     * @return Response
     */
    public function downloadSingle(Request $request):Response{
        $params = [];
        $tid = $request->request->get("tid");
        $series = $request->request->get("series");
        $name = $request->request->get("name");
        $category = $request->request->get("category");
        $cc = $request->request->get("cc");
        $title = "";
        if ($tid){
            $params["tid"] = $tid;
            $title .= $tid."--";
        }
        if ($series){
            $params["series"] = $series;
            $title .= $series."--";

        }
        if ($name){
            $params["name"] = $name;
            $title .= $name."--";

        }

        if ($category){
            $params["category"] = $category;
            $title .= $category."--";

        }
        if ($cc){
            $params["cc"] = $cc;
            $title .= $cc."--";

        }
        $repostitory = $this->getDoctrine()->getRepository(Single::class);

        $items = $repostitory->findBy($params);
        $stores = [];
        if ($items){
            foreach($items as $key=>$item){
                $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
                $stores[$key]["store"] = $storeRepostitory->findResultsByIdsAndDate($item->getId());
                $stores[$key]["item"] = $item;
            }
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("库存");

        for ($i=0;$i<count($stores);$i++){
            $sheet->setCellValueByColumnAndRow(1, $i+1,$stores[$i]["item"]->getId() );
            $sheet->setCellValueByColumnAndRow(2, $i+1,$stores[$i]["item"]->getName() );
            $sheet->setCellValueByColumnAndRow(3, $i+1,$stores[$i]["item"]->getTid() );
            $sheet->setCellValueByColumnAndRow(4, $i+1,$stores[$i]["item"]->getSeries() );
            $m = 0;
            for ($j=0;$j<count($stores[$i]["store"]);$j++){
                $sheet->setCellValueByColumnAndRow(5+$j+$m, $i+1, $stores[$i]["store"][$j]["cdate"]);
                $m++;
                $sheet->setCellValueByColumnAndRow(5+$j+$m, $i+1, $stores[$i]["store"][$j]["data"]);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $title.SMTools::getDateString().'-单味品.xlsx';
        $excelFilepath =  $this->publicDirectory .'/'.$filename;

        $writer->save($excelFilepath);



        return $this->render("download.html.twig",[
            'filename'=>$filename
        ]);

    }



    /**
     * @Route ("/store/herb/download")
     * @param Request $request
     * @return Response
     */
    public function downloadHerb(Request $request):Response{

        $params = [];

        $id = $request->request->get("id");
        $tid = $request->request->get("tid");
        $series = $request->request->get("series");
        $subSeries = $request->request->get("subSeries");
        $name = $request->request->get("name");
        $title = "";

        if ($id){
            $params["id"] = $id;
            $title .= $id . "--";
        }

        if ($tid){
            $params["tid"] = $tid;
            $title .= $tid . "--";
        }



        if ($series){
            $params["series"] = $series;
            $title .= $series . "--";

        }


        if ($subSeries){
            $params["subSeries"] = $subSeries;
            $title .= $subSeries . "--";
        }

        if ($name){
            $params["name"] = $name;
            $title .= $name . "--";
        }

        $repostitory = $this->getDoctrine()->getRepository(Herb::class);

        $items = $repostitory->findBy($params);

        $stores = [];
        if ($items){
            foreach($items as $key=>$item){
                $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
                $stores[$key]["store"] = $storeRepostitory->findResultsByIdsAndDate($item->getId());
                $stores[$key]["item"] = $item;
            }
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("库存");

        for ($i=0;$i<count($stores);$i++){
            $sheet->setCellValueByColumnAndRow(1, $i+1,$stores[$i]["item"]->getId() );
            $sheet->setCellValueByColumnAndRow(2, $i+1,$stores[$i]["item"]->getTid() );
            $sheet->setCellValueByColumnAndRow(3, $i+1,$stores[$i]["item"]->getSeries() );
            $sheet->setCellValueByColumnAndRow(4, $i+1,$stores[$i]["item"]->getSubSeries() );
            $sheet->setCellValueByColumnAndRow(5, $i+1,$stores[$i]["item"]->getName() );

            $m = 0;
            for ($j=0;$j<count($stores[$i]["store"]);$j++){
                $sheet->setCellValueByColumnAndRow(6+$j+$m, $i+1, $stores[$i]["store"][$j]["cdate"]);
                $m++;
                $sheet->setCellValueByColumnAndRow(6+$j+$m, $i+1, $stores[$i]["store"][$j]["data"]);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $title.SMTools::getDateString().'-草本.xlsx';
        $excelFilepath =  $this->publicDirectory .'/'.$filename;

        $writer->save($excelFilepath);


        return $this->render("download.html.twig",[
            'filename'=>$filename
        ]);

    }


    /**
     * @Route ("/store/download/medical")
     * @param Request $request
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function downloadMedical(Request $request):Response{

        $repostitory = $this->getDoctrine()->getRepository(Medical::class);

        $params = [];
        $type = $request->request->get("type",0);
        $series = $request->request->get("series","");
        $category = $request->request->get("category","");
        $tid = $request->request->get("tid","");

        $title = "";

        if ($type){
            $params["type"] = $type;
            $title .= $type."--";
        }

        if ($series){
            $params["series"] = $series;
            $title .= $series."--";
        }

        if ($category){
            $params["category"] = $category;
            $title .= $category."--";

        }

        if ($tid){
            $params["tid"] = $tid;
            $title .= $tid."--";
        }

        $items = $repostitory->findBy($params);

        $stores = [];
        if ($items){
            foreach($items as $key=>$item){
                $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
                $stores[$key]["store"] = $storeRepostitory->findResultsByIdsAndDate($item->getId());
                $stores[$key]["item"] = $item;
            }
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("库存");


        for ($i=0;$i<count($stores);$i++){

            $sheet->setCellValueByColumnAndRow(1, $i+1,$stores[$i]["item"]->getId() );
            $sheet->setCellValueByColumnAndRow(2, $i+1,$stores[$i]["item"]->getType() );
            $sheet->setCellValueByColumnAndRow(3, $i+1,$stores[$i]["item"]->getSeries() );
            $sheet->setCellValueByColumnAndRow(4, $i+1,$stores[$i]["item"]->getCategory() );
            $sheet->setCellValueByColumnAndRow(5, $i+1,$stores[$i]["item"]->getTid() );

            $m = 0;
            for ($j=0;$j<count($stores[$i]["store"]);$j++){
                $sheet->setCellValueByColumnAndRow(6+$j+$m, $i+1, $stores[$i]["store"][$j]["cdate"]);
                $m++;
                $sheet->setCellValueByColumnAndRow(6+$j+$m, $i+1, $stores[$i]["store"][$j]["data"]);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $title.SMTools::getDateString().'-复方药.xlsx';
        $excelFilepath =  $this->publicDirectory .'/'.$filename;

        $writer->save($excelFilepath);

        return $this->render("download.html.twig",[
            'filename'=>$filename
        ]);

    }



    /**
     * @Route ("/store/herb/template")
     * @param Request $request
     * @return Response
     */
    public function herbTemplate(Request $request):Response{

        $params = [];

        $id = $request->request->get("id");
        $tid = $request->request->get("tid");
        $series = $request->request->get("series");
        $subSeries = $request->request->get("subSeries");
        $name = $request->request->get("name");
        $title = "";

        if ($id){
            $params["id"] = $id;
            $title .= $id . "--";
        }

        if ($tid){
            $params["tid"] = $tid;
            $title .= $tid . "--";
        }



        if ($series){
            $params["series"] = $series;
            $title .= $series . "--";

        }


        if ($subSeries){
            $params["subSeries"] = $subSeries;
            $title .= $subSeries . "--";
        }

        if ($name){
            $params["name"] = $name;
            $title .= $name . "--";
        }

        $repostitory = $this->getDoctrine()->getRepository(Herb::class);

        $items = $repostitory->findBy($params);


        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("库存");

        $sheet->setCellValueByColumnAndRow(1, 1,"id" );
        $sheet->setCellValueByColumnAndRow(2, 1,"tid" );
        $sheet->setCellValueByColumnAndRow(3, 1, "series");
        $sheet->setCellValueByColumnAndRow(4, 1,"subSeries" );
        $sheet->setCellValueByColumnAndRow(5, 1,"name" );
        $sheet->setCellValueByColumnAndRow(6, 1,SMTools::getDateLocal() );


        for($i=0;$i<count($items);$i++){
            $sheet->setCellValueByColumnAndRow(1, $i+2,$items[$i]->getId() );
            $sheet->setCellValueByColumnAndRow(2, $i+2,$items[$i]->getTid() );
            $sheet->setCellValueByColumnAndRow(3, $i+2,$items[$i]->getSeries() );
            $sheet->setCellValueByColumnAndRow(4, $i+2,$items[$i]->getSubSeries() );
            $sheet->setCellValueByColumnAndRow(5, $i+2,$items[$i]->getName() );
        }



        $writer = new Xlsx($spreadsheet);
        $filename = $title.SMTools::getDateString().'-草本-template.xlsx';
        $excelFilepath =  $this->publicDirectory .'/'.$filename;

        $writer->save($excelFilepath);


        return $this->render("download.html.twig",[
            'filename'=>$filename
        ]);

    }

    /**
     * @Route ("/store/medical/template")
     * @param Request $request
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function medicalTemplate(Request $request):Response{

        $repostitory = $this->getDoctrine()->getRepository(Medical::class);

        $params = [];
        $type = $request->request->get("type",0);
        $series = $request->request->get("series","");
        $category = $request->request->get("category","");
        $tid = $request->request->get("tid","");

        $title = "";

        if ($type){
            $params["type"] = $type;
            $title .= $type."--";
        }

        if ($series){
            $params["series"] = $series;
            $title .= $series."--";
        }

        if ($category){
            $params["category"] = $category;
            $title .= $category."--";

        }

        if ($tid){
            $params["tid"] = $tid;
            $title .= $tid."--";
        }

        $items = $repostitory->findBy($params);


        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("库存");

        $sheet->setCellValueByColumnAndRow(1, 1,"id" );
        $sheet->setCellValueByColumnAndRow(2, 1,"type" );
        $sheet->setCellValueByColumnAndRow(3, 1,"series" );
        $sheet->setCellValueByColumnAndRow(4, 1,"category");
        $sheet->setCellValueByColumnAndRow(5, 1,"tid" );
        $sheet->setCellValueByColumnAndRow(6, 1,SMTools::getDateLocal() );

        for ($i=0;$i<count($items);$i++){

            $sheet->setCellValueByColumnAndRow(1, $i+2,$items[$i]->getId() );
            $sheet->setCellValueByColumnAndRow(2, $i+2,$items[$i]->getType() );
            $sheet->setCellValueByColumnAndRow(3, $i+2,$items[$i]->getSeries() );
            $sheet->setCellValueByColumnAndRow(4, $i+2,$items[$i]->getCategory() );
            $sheet->setCellValueByColumnAndRow(5, $i+2,$items[$i]->getTid() );

        }

        $writer = new Xlsx($spreadsheet);
        $filename = $title.SMTools::getDateString().'-复方药-template.xlsx';
        $excelFilepath =  $this->publicDirectory .'/'.$filename;

        $writer->save($excelFilepath);

        return $this->render("template.html.twig",[
            'filename'=>$filename
        ]);

    }

    /**
     * @Route ("/store/single/template")
     * @param Request $request
     * @return Response
     */
    public function singleTemplate(Request $request):Response{
        $tid = $request->request->get("tid");
        $series = $request->request->get("series");
        $name = $request->request->get("name");
        $category = $request->request->get("category");
        $cc = $request->request->get("cc");
        $title = "";
        if ($tid){
            $params["tid"] = $tid;
            $title .= $tid."--";
        }
        if ($series){
            $params["series"] = $series;
            $title .= $series."--";

        }
        if ($name){
            $params["name"] = $name;
            $title .= $name."--";

        }

        if ($category){
            $params["category"] = $category;
            $title .= $category."--";

        }
        if ($cc){
            $params["cc"] = $cc;
            $title .= $cc."--";

        }
        $repostitory = $this->getDoctrine()->getRepository(Single::class);

        $items = $repostitory->findBy($params);


        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("库存");

        $sheet->setCellValueByColumnAndRow(1, 1,"id");
        $sheet->setCellValueByColumnAndRow(2, 1,"name" );
        $sheet->setCellValueByColumnAndRow(3, 1,"tid" );
        $sheet->setCellValueByColumnAndRow(4, 1,"series" );
        $sheet->setCellValueByColumnAndRow(5,1,"cc");
        $sheet->setCellValueByColumnAndRow(6, 1,SMTools::getDateLocal() );

        for ($i=0;$i<count($items);$i++){
            $sheet->setCellValueByColumnAndRow(1, $i+2,$items[$i]->getId() );
            $sheet->setCellValueByColumnAndRow(2, $i+2,$items[$i]->getName() );
            $sheet->setCellValueByColumnAndRow(3, $i+2,$items[$i]->getTid() );
            $sheet->setCellValueByColumnAndRow(4, $i+2,$items[$i]->getSeries() );
            $sheet->setCellValueByColumnAndRow(5, $i+2,$items[$i]->getCc() );
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $title.SMTools::getDateString().'-单味品-template.xlsx';
        $excelFilepath =  $this->publicDirectory .'/'.$filename;

        $writer->save($excelFilepath);


        return $this->render("download.html.twig",[
            'filename'=>$filename
        ]);

    }


    /**
     * @Route ("/store/upload")
     */
    public function uploadStore(Request $request):Response{
        $upload = new Upload();
        $form = $this->createForm(UploadFormType::class,$upload);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($upload->getType()>0){
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $upload->getFile();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->uploadPath,
                    $fileName
                );
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($this->uploadPath.$fileName);


                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow(); // 总行数
                $highestColumn = $worksheet->getHighestColumn(); // 总列数
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);


                $lines = $highestRow - 2;
                if ($lines <= 0) {
                    exit('Excel表格中没有数据');
                }

                if ($upload->getType()==1){
                    $cdate = $worksheet->getCellByColumnAndRow(6, 1)->getValue();
                    for ($row = 2; $row <= $highestRow; ++$row) {
                        $id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $count = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        if ($id && $count){
                            $store = new Store();
                            $store->setUtime(SMTools::getDateString());
                            $store->setCtime(SMTools::getDateString());
                            $store->setTid($id);
                            $store->setData($count);
                            $store->setCdate($cdate);
                            $store->setType(5);
                            $store->setStype(0);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($store);
                            $entityManager->flush();
                        }
                        return $this->render("store/success.html.twig",[
                            "message"=>"原材料库存上载成功"
                        ]);

                    }

                }else if ($upload->getType()==2){
                    $cdate = $worksheet->getCellByColumnAndRow(6, 1)->getValue();
                    for ($row = 2; $row <= $highestRow; ++$row) {
                        $id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $count = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        if ($id && $count){
                            $store = new Store();
                            $store->setUtime(SMTools::getDateString());
                            $store->setCtime(SMTools::getDateString());
                            $store->setTid($id);
                            $store->setData($count);
                            $store->setCdate($cdate);
                            $store->setType(4);
                            $store->setStype(0);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($store);
                            $entityManager->flush();
                        }
                    }
                    return $this->render("store/success.html.twig",[
                        "message"=>"单味品库存上载成功"
                    ]);
                }else if ($upload->getType()==3){
                    $cdate = $worksheet->getCellByColumnAndRow(6, 1)->getValue();
                    for ($row = 2; $row <= $highestRow; ++$row) {
                        $id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $type = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $count = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        if ($id && $count){
                            $store = new Store();
                            $store->setUtime(SMTools::getDateString());
                            $store->setCtime(SMTools::getDateString());
                            $store->setTid($id);
                            $store->setData($count);
                            $store->setCdate($cdate);
                            $store->setType($type);
                            $store->setStype(0);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($store);
                            $entityManager->flush();
                        }
                    }
                    return $this->render("store/success.html.twig",[
                        "message"=>"复方药库存上载成功"
                    ]);
                }

            }

        }

        return $this->render("store/upload.html.twig",[
            "upload_form"=>$form->createView()
        ]);
    }

    /**
     * @Route ("/store/usage")
     */
    public function uploadUsage(Request $request):Response{
        $upload = new Upload();
        $form = $this->createForm(UploadFormType::class,$upload);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($upload->getType()>0){
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $upload->getFile();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->uploadPath,
                    $fileName
                );
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($this->uploadPath.$fileName);


                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow(); // 总行数
                $highestColumn = $worksheet->getHighestColumn(); // 总列数
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);


                $lines = $highestRow - 2;
                if ($lines <= 0) {
                    exit('Excel表格中没有数据');
                }

                if ($upload->getType()==1){
                    $cdate = $worksheet->getCellByColumnAndRow(6, 1)->getValue();
                    for ($row = 2; $row <= $highestRow; ++$row) {
                        $id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $count = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        if ($id && $count){
                            $store = new Store();
                            $store->setUtime(SMTools::getDateString());
                            $store->setCtime(SMTools::getDateString());
                            $store->setTid($id);
                            $store->setData($count);
                            $store->setCdate($cdate);
                            $store->setType(5);
                            $store->setStype(1);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($store);
                            $entityManager->flush();
                        }
                        return $this->render("store/success.html.twig",[
                            "message"=>"原材料用量上载成功"
                        ]);

                    }

                }else if ($upload->getType()==2){
                    $cdate = $worksheet->getCellByColumnAndRow(6, 1)->getValue();
                    for ($row = 2; $row <= $highestRow; ++$row) {
                        $id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $count = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        if ($id && $count){
                            $store = new Store();
                            $store->setUtime(SMTools::getDateString());
                            $store->setCtime(SMTools::getDateString());
                            $store->setTid($id);
                            $store->setData($count);
                            $store->setCdate($cdate);
                            $store->setType(4);
                            $store->setStype(1);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($store);
                            $entityManager->flush();
                        }
                    }
                    return $this->render("store/success.html.twig",[
                        "message"=>"单味品用量上载成功"
                    ]);
                }else if ($upload->getType()==3){
                    $cdate = $worksheet->getCellByColumnAndRow(6, 1)->getValue();
                    for ($row = 2; $row <= $highestRow; ++$row) {
                        $id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $type = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $count = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        if ($id && $count){
                            $store = new Store();
                            $store->setUtime(SMTools::getDateString());
                            $store->setCtime(SMTools::getDateString());
                            $store->setTid($id);
                            $store->setData($count);
                            $store->setCdate($cdate);
                            $store->setType($type);
                            $store->setStype(1);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($store);
                            $entityManager->flush();
                        }
                    }
                    return $this->render("store/success.html.twig",[
                        "message"=>"复方药用量上载成功"
                    ]);
                }

            }
        }

        return $this->render("store/usage.html.twig",[
            "upload_form"=>$form->createView()
        ]);
    }

    /**
     * @Route ("/store/herb/detail")
     * @param Request $request
     * @return Response
     */
    public function herbStoreDetail(Request $request):Response{
        $id = $request->query->get("id",0);
        $repository = $this->getDoctrine()->getRepository(Herb::class);
        $herb = $repository->findOneById($id);
        $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
        $stores["store"] = $storeRepostitory->findResultsByIdsAndDate($id,5);
        $stores["item"] = $herb;
        return $this->render("store/store.herb.detail.html.twig",[
            "stores"=>$stores
        ]);

    }


    /**
     * @Route ("/store/medical/detail")
     * @param Request $request
     * @return Response
     */
    public function medicalStoreDetail(Request $request):Response{
        $id = $request->query->get("id",0);
        $repository = $this->getDoctrine()->getRepository(Medical::class);
        $medical = $repository->findOneById($id);

        $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
        $stores["store"] = $storeRepostitory->findResultsByIdsAndDate($id,$medical->getType());
        $stores["item"] = $medical;

        return $this->render("store/store.medical.detail.html.twig",[
            "stores"=>$stores
        ]);

    }

    /**
     * @Route ("/store/single/detail")
     * @param Request $request
     * @return Response
     */
    public function singleStoreDetail(Request $request):Response{
        $id = $request->query->get("id",0);
        $stores = [];
        $repository = $this->getDoctrine()->getRepository(Single::class);
        $single = $repository->findOneById($id);


        $storeRepostitory = $this->getDoctrine()->getRepository(Store::class);
        $stores["store"] = $storeRepostitory->findAllStoreByIdsAndTypes($id,$single->getType());
        $stores["item"] = $single;

        return $this->render("store/store.single.detail.html.twig",[
            "stores"=>$stores
        ]);

    }
}