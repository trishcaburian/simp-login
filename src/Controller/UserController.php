<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use App\Models\UserModel;
use Twig\Environment;

class UserController extends AbstractController
{
    private $twigEnvironment, $userModel, $security;

    public function __construct(Environment $twigEnvironment, UserModel $userModel, Security $security)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->userModel = $userModel;
        $this->security = $security;
    }

    /**
    *   @Route("/create_user", name="create_user")
    */
    public function createUser(Request $request)
    {
        $messages = $this->userModel->addUser($request);

        return new Response($this->twigEnvironment->render('pages/register.html.twig', ['messages' => $messages]));
    }

    /**
    *   @Route("/add_user_admin", name="add_user_admin")
    */
    public function giveUserAdminRights(Request $request)
    {
        $user = $this->security->getUser();

        $messages = $this->userModel->addAdmin($user, $request);

        return new Response($this->twigEnvironment->render('pages/admin_dash.html.twig', ['messages' => $messages]));
    }
}
