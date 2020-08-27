<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
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
    *   @Route("/homepage", name="homepage")
    */
    public function loadHomepage(): Response
    {
        $user = $this->security->getUser();
        
        if (!is_null($user)) {
            return $this->render("pages/home.html.twig", ['username' => $user->getUsername()]);
        } else {
            return $this->redirect($this->generateUrl('app_login'));
        }
        
    }
}
