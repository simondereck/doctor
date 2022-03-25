<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\User;
use App\Form\AdminFormType;
use App\Form\AdminLoginType;
use App\Form\AdminUpdateFormType;
use App\Form\UserFormType;
use App\Tools\PageNation;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\SMTools;
use function Symfony\Component\String\s;

class AdminController extends MainController
{


    public function __construct(SessionInterface $session)
    {
        parent::__construct($session);
    }




    /**
     * @Route ("/admin/create")
     * @return Response
     */
    public function create(Request $request):Response
    {
        if (!$this->isAdmin()){
            return $this->loginAsAdmin();
        }

        $admin = new Admin();

        $form = $this->createForm(AdminFormType::class,$admin);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $admin->setUtime(SMTools::getDateString());
            $admin->setCtime(SMTools::getDateString());
            $admin->setPassword($admin->generatePassword());
            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
            return $this->redirect("/admin/lists");
        }
        return $this->render("admin/create.html.twig",[
            "admin_form"=>$form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route ("/admin/create/user")
     */
    public function createUser(Request $request):Response
    {
        if (!$this->isAdmin()){
            return $this->loginAsAdmin();
        }
        $user = new User();
        $form = $this->createForm(UserFormType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setUtime(SMTools::getDateString());
            $user->setCtime(SMTools::getDateString());
            $user->setPassword($user->generatePassword());
            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
            return $this->redirect("/admin/users/lists");
        }

        return $this->render("admin/user.create.html.twig",[
            "user_form"=>$form->createView()
        ]);
    }


    /**
     * @return Response
     * @Route ("/admin/lists")
     */
    public function adminLists(Request $request):Response
    {
        if (!$this->isAdmin()){
            return $this->loginAsAdmin();
        }
        $repository = $this->getDoctrine()->getRepository(Admin::class);

        $count = $repository->count([]);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $page = $request->query->get("page",0);
        $pageNation->setPage($page);
        $pageNation->setBaseUrl("/admin/lists");
        $results = $repository->findBy([],["id"=>"desc"],$pageNation->getLimit(),$pageNation->getOffset());

        return $this->render("admin/admin.lists.html.twig",[
            "items"=>$results,
            "pages" => $pageNation->getPages(),
            "currentPage"=>$pageNation->getPage()
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/update/admin")
     */
    public function adminUpdate(Request $request):Response
    {
        if (!$this->isAdmin()){
            return $this->loginAsAdmin();
        }
        $id = $request->query->get("id",null);
        if ($id){
            $repository = $this->getDoctrine()->getRepository(Admin::class);
            $admin = $repository->findOneById($id);
            $form = $this->createForm(AdminUpdateFormType::class,$admin);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $admin->setUtime(SMTools::getDateString());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($admin);
                $entityManager->flush();
                return $this->redirect("/admin/lists");
            }
            return $this->render("admin/admin.update.html.twig",[
                "admin_form"=> $form->createView(),
                "id"=>$id
            ]);
        }
        return $this->error("NO ID FOUND");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/delete/admin")
     */
    public function adminDelete(Request $request):Response
    {
        if (!$this->isAdmin()){
            return $this->loginAsAdmin();
        }
        $id = $request->query->get("id",null);
        if ($id){
            $repository = $this->getDoctrine()->getRepository(Admin::class);
            $admin = $repository->findOneById($id);
            if ($admin){
                $em = $this->getDoctrine()->getManager();
                $em->remove($admin);
                $em->flush();
                return $this->redirect("/admin/lists");
            }

        }
        return $this->error("NO ID FOUND");
    }
    /**
     * @return Response
     * @Route("/admin/users/lists")
     */
    public function adminUserLists(Request $request):Response
    {

        if (!$this->isAdmin()){
            return $this->loginAsAdmin();
        }
        $repository = $this->getDoctrine()->getRepository(User::class);
        $count = $repository->count([]);
        $page = $request->query->get("page",0);
        $pageNation = new PageNation();
        $pageNation->setTotal($count);
        $pageNation->setBaseUrl("/admin/users/lists");
        $pageNation->setPage($page);
        $items = $repository->findBy([],["id"=>"desc"],$pageNation->getLimit(),$pageNation->getOffset());


        return $this->render("admin/admin.users.lists.html.twig",[
            "items"=>$items,
            "pages" => $pageNation->getPages(),
            "currentPage"=>$pageNation->getPage()
        ]);
    }



}
