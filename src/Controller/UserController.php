<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserLoginType;
use App\Tools\SMTools;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends MainController
{

    /**
     * @param Request $request
     * @return Response
     * @Route ("/user/login")
     */
    public function login(Request $request):Response
    {
        $user = new User();
        $form = $this->createForm(UserLoginType::class,$user);
        $form->handleRequest($request);
        $error = "";
        if ($form->isSubmitted()&&$form->isValid()){
            //login success
            $repository = $this->getDoctrine()->getRepository(User::class);
            $result = $repository->findOneByLogin($user->getUsername());
            if ($result && $user->login($result)){
                $this->session->set("user",$result);
                $this->session->set("type",SMTools::$IS_USER);
                return $this->redirect("/");
            }else{
                $error = "登陆名或密码有错";
            }
        }
        return $this->render("user/login.html.twig",[
            "user_login_form"=>$form->createView(),
            "error" =>$error
        ]);
    }





}
