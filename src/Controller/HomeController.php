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
    *   @Route("/", name="homepage")
    */
    public function index(): Response
    {
        $user = $this->security->getUser();
        
        return $this->render("pages/home.html.twig", ['username' => $user->getUsername()]);

    }

    /**
    *   @Route("/hub", name="hub_page")
    */
    public function loadHubPage(): Response
    {
        return $this->render("pages/hub.html.twig", ['user' => $this->security->getUser()]);
    }

    /**
     *  @Route("/register", name="register_page")
    */
    public function loadRegisterPage()
    {
        return $this->render("pages/register.html.twig", ['messages' => []]);
    }
}
