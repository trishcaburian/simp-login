<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
    *   @Route("/login", name="login_page")
    */
    public function loginPage(UserInterface $user): Response
    {
        if ($user->getIsLogin()){
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render("pages/login.html.twig");
    }

    /**
    *   @Route("/homepage", name="homepage")
    */
    public function loadHomepage(UserInterface $user): Response
    {
        $username = $user->getUsername();
        
        if ($user->getIsLogin()) {
            return $this->render("pages/home.html.twig", ["username" => $username]);
        } else {
            return $this->redirect($this->generateUrl('login_page'));
        }
        
    }

    /**
    *   @Route("/logout", name="logout")
    */
    public function logout(UserInterface $user)
    {
        $user->setIsLogin(false);
        return $this->redirect($this->generateUrl('login_page'));
    }
}
