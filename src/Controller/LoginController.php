<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
    *   @Route("/login", name="login_page")
    */
    public function loginPage(): Response
    {
        return $this->render("pages/login.html.twig");
    }

    /**
    *   @Route("/homepage", name="homepage")
    */
    public function loadHomepage(): Response
    {
        // $username = $user->getUsername();
        
        if (true) {
            return $this->render("pages/home.html.twig", ["username" => $username]);
        } else {
            return $this->redirect($this->generateUrl('login_page'));
        }
        
    }

    /**
    *   @Route("/logout", name="logout")
    */
    public function logout()
    {
        return $this->redirect($this->generateUrl('login_page'));
    }
}
