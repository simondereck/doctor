<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminLoginType;
use App\Tools\SMTools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends MainController
{
    /**
     * @Route("/", name="site")
     */
    public function index(): Response
    {
        return $this->render("site/index.html.twig");
    }


    /**
     * @return Response
     * @Route ("/site/about")
     */
    public function about():Response
    {

        return $this->render("site/about.html.twig");
    }

    /**
     * @Route ("/admin/login")
     * @return Response
     */
    public function adminLogin(Request $request):Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminLoginType::class,$admin);
        $form->handleRequest($request);
        $error = "";
        if ($form->isSubmitted()&&$form->isValid()){
            $repository = $this->getDoctrine()
                ->getRepository(Admin::class);
            $result = $repository->findOneByLogin($admin->getUsername());
            if ($result && $admin->login($result)){
                $this->session->set("user",$result);
                $this->session->set("type",SMTools::$IS_ADMIN);
                return $this->redirect("/");
            }else{
                $error = "登陆名或密码有错";
            }
        }
        return $this->render("admin/login.html.twig",[
            'admin_login_form'=>$form->createView(),
            'error'=>$error
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/logout")
     */
    public function logout(Request $request):Response
    {
        $this->session->remove("user");
        $this->session->remove("type");
        return $this->redirect("/");
    }


}
