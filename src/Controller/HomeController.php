<?php
namespace App\Controller;

use App\Entity\User;
use App\Models\UserModel;
use App\Services\RegisterType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class HomeController extends AbstractController
{
    private $userModel, $security;

    public function __construct(UserModel $userModel, Security $security)
    {
        $this->userModel = $userModel;
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
    public function loadRegisterPage(Request $request)
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $message = $this->userModel->addUser($request);
            return $this->render("pages/register.html.twig", ['form' => $form->createView(), 'message' => $message]);
        }

        return $this->render("pages/register.html.twig", ['form' => $form->createView()]);
    }
}
