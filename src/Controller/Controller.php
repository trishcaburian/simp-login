<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class Controller extends AbstractController
{
    public function helloWorld(): Response
    {
        return new Response(
            '<html><body>hello world</body></html>'
        );
    }

    public function loginPage(UserInterface $user): Response
    {
        if ($user->getIsLogin()){
            return $this->redirect($this->generateUrl('verify_login'));
        }

        return $this->render("pages/login.html.twig");
    }

    public function checkLogin(UserInterface $user): Response
    {
        $username = $user->getUsername();
        
        if ($user->getIsLogin()) {
            return $this->render("pages/home.html.twig", ["username" => $username]);
        } else {
            return $this->redirect($this->generateUrl('login_page'));
        }
        
    }

    public function logout(UserInterface $user)
    {
        $user->setIsLogin(false);
        return $this->redirect($this->generateUrl('login_page'));
    }
}
