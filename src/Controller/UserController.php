<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Models\UserModel;
use Twig\Environment;

class UserController extends AbstractController
{
    private $twigEnvironment, $userModel;

    public function __construct(Environment $twigEnvironment, UserModel $userModel)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->userModel = $userModel;
    }

    /**
    *   @Route("/create_user", name="create_user")
    */
    public function createUser(Request $request)
    {
        $messages = $this->userModel->addUser($request);

        return new Response($this->twigEnvironment->render('pages/register.html.twig', ['messages' => $messages]));
    }
}
