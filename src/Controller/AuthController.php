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
    *   @Route("/auth/login", name="app_login")
    */
    public function loginPage(): Response
    {
        if (!is_null($this->security->getUser())) { 
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render("pages/login.html.twig");
    }

    /**
    *   @Route("/logout", name="app_logout")
    */
    public function logout()
    {
        return $this->redirect($this->generateUrl('app_login'));
    }
}
