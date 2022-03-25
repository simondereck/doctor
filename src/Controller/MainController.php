<?php


namespace App\Controller;


use App\Tools\SMTools;
use http\Client\Curl\User;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
//        $request = Request::createFromGlobals();
//        $path = $request->getPathInfo();
    }

    public function isLogin():bool
    {
        $user = $this->session->get("user");
        if ($user){
            return true;
        }
        return false;
    }

    public function isAdmin():bool
    {
        $type = $this->session->get("type");
        if ($type==SMTools::$IS_ADMIN){
            return true;
        }
        return false;
    }

    public function getUser():? User
    {
        return $this->session->get("user");
    }

    public function actions(){
        return [];
    }


    public function error($error){
        return $this->render("site/error.html.twig",[
            "message"=>$error
        ]);
    }


    public function loginAsAdmin(){
        return $this->error("你没有管理员权限，请用管理员账户登陆");
    }
}