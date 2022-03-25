<?php

namespace App\Controller;

use App\Entity\Law;
use App\Entity\Usage;
use App\Form\LawFormType;
use App\Form\LawUpdateFormType;
use App\Form\UsageFormType;
use App\Form\UsageUpdateFormType;
use App\Tools\PageNation;
use App\Tools\SMTools;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LawController extends MainController
{
    /**
     * @Route("/law", name="law")
     */
    public function index(Request $request): Response
    {

        $page = $request->query->get("page",0);

        $repository = $this->getDoctrine()->getRepository(Law::class);
        $count = $repository->count([]);
        $pageNation = new PageNation();
        $pageNation->setPage($page);
        $pageNation->setBaseUrl("/law");
        $pageNation->setTotal($count);
        $items = $repository->findBy([],[],$pageNation->getLimit(),$pageNation->getOffset());


        return $this->render('law/index.html.twig', [
            "items"=>$items,
            "pages"=>$pageNation->getPages(),
            "currentPage"=>$pageNation->getPage()
        ]);
    }

    /**
     * @param Request $request
     * @return Request
     * @Route("/usage/lists")
     */

    public function useLists(Request $request):Response
    {
        $page = $request->query->get("page",0);

        $repository = $this->getDoctrine()->getRepository(Usage::class);
        $count = $repository->count([]);
        $pageNation = new PageNation();
        $pageNation->setPage($page);
        $pageNation->setBaseUrl("/usage/lists");
        $pageNation->setTotal($count);
        $items = $repository->findBy([],[],$pageNation->getLimit(),$pageNation->getOffset());


        return $this->render("law/usage.lists.html.twig",[
            "items"=>$items,
            "pages"=>$pageNation->getPages(),
            "currentPage"=>$pageNation->getPage()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/law/detail")
     */
    public function lawDetail(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Law::class);
            $law = $repostitory->findOneById($id);
            if ($law){
                return $this->render("law/law.detail.html.twig",[
                    "item"=>$law
                ]);
            }

            return $this->error("找不到相关的条目");
        }
        return $this->error("请提供正确的ID");
    }


    /**
     * @param Request $request
     * @return Response
     * @Route ("/usage/detail")
     */
    public function usageDetail(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Usage::class);
            $usage = $repostitory->findOneById($id);
            if ($usage){
                return $this->render("law/usage.detail.html.twig",[
                    "item"=>$usage
                ]);
            }

            return $this->error("找不到相关的条目");
        }
        return $this->error("请提供正确的ID");
    }


    /**
     * @param Request $request
     * @return Response
     * @Route("/law/delete")
     */
    public function deteleLaw(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Law::class);
            $law = $repostitory->findOneById($id);
            if ($law){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($law);
                $entityManager->flush();
                return $this->redirect("/law");
            }

            return $this->error("找不到相关的条目");
        }
        return $this->error("请提供正确的ID");

    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/usage/delete")
     */
    public function deleteUsage(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Usage::class);
            $usage = $repostitory->findOneById($id);
            if ($usage){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($usage);
                $entityManager->flush();
                return $this->redirect("/usage/lists");
            }

            return $this->error("找不到相关的条目");
        }
        return $this->error("请提供正确的ID");
    }


    /**
     * @param Request $request
     * @return Response
     * @Route ("/usage/create")
     */
    public function createUsage(Request $request):Response
    {
        $usage = new Usage();
        $form = $this->createForm(UsageFormType::class,$usage);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $usage->setCtime(SMTools::getDateString());
            $usage->setUtime(SMTools::getDateString());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usage);
            $entityManager->flush();
            return $this->redirect("/usage/lists");
        }


        return $this->render("law/usage.create.html.twig",[
            "usage_form"=>$form->createView()
        ]);

    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/law/create")
     */
    public function createLaw(Request $request):Response
    {
        $law = new Law();
        $form = $this->createForm(LawFormType::class,$law);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $law->setCtime(SMTools::getDateString());
            $law->setUtime(SMTools::getDateString());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($law);
            $entityManager->flush();
            return $this->redirect("/law");
        }


        return $this->render("law/law.create.html.twig",[
            "law_form"=>$form->createView()
        ]);
    }

    public function updateUsage(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Usage::class);
            $usage = $repostitory->findOneById($id);
            if ($usage){
                $form = $this->createForm(UsageUpdateFormType::class,$usage);
                $form->handleRequest($request);
                if ($form->isSubmitted()&&$form->isValid()){
                    //update
                    $usage->setUtime(SMTools::getDateString());
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($usage);
                    $entityManager->flush();
                    return $this->redirect("/usage/detail?id=".$id);
                }
                return $this->render("law/usage.update.html.twig",[
                    "usage_form"=>$form->createView()
                ]);
            }
           return $this->error("找不到相对应的条目");
        }
        return $this->error("请提供正确的ID");
    }

    public function updateLaw(Request $request):Response
    {
        $id = $request->query->get("id",0);
        if ($id>0){
            $repostitory = $this->getDoctrine()->getRepository(Law::class);
            $law = $repostitory->findOneById($id);
            if ($law){
                $form = $this->createForm(LawUpdateFormType::class,$law);
                $form->handleRequest($request);
                if ($form->isSubmitted()&&$form->isValid()){
                    //update
                    $law->setUtime(SMTools::getDateString());
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($law);
                    $entityManager->flush();
                    return $this->redirect("/law/detail?id=".$id);
                }
                return $this->render("law/law.update.html.twig",[
                    "usage_form"=>$form->createView()
                ]);
            }
            return $this->error("找不到相对应的条目");
        }
        return $this->error("请提供正确的ID");
    }


}
