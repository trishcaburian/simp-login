<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AuthController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
    *   @Route("/", name="neutral_page")
    */
    public function index() 
    {
        //move with homepage to a new controller later
        return $this->redirect($this->generateUrl('app_login'));

    }

    /**
    *   @Route("/auth/login", name="app_login")
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
        $username = $this->security->getUser()->getUsername();
        
        if (true) {
            return $this->render("pages/home.html.twig", ['username' => $username]);
        } else {
            return $this->redirect($this->generateUrl('login_page'));
        }
        
    }

    /**
    *   @Route("/logout", name="app_logout")
    */
    public function logout()
    {
        return $this->redirect($this->generateUrl('login_page'));
    }
}
