<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use App\Models\UserModel;

class UserController extends AbstractController
{
    private $userModel, $security;

    public function __construct(UserModel $userModel, Security $security)
    {
        $this->userModel = $userModel;
        $this->security = $security;
    }

    /**
    *   @Route("/create_user", name="create_user")
    */
    public function createUser(Request $request)
    {
        if (is_null($request->headers->get('referer'))) {
            return $this->render('errors/default.html.twig', ['error_message' => 'Sorry, direct access to this page is not allowed.']);
        }

        $messages = $this->userModel->addUser($request);

        return $this->render('pages/register.html.twig', ['messages' => $messages]);
    }

    /**
    *   @Route("/admin/add_user_admin", name="add_user_admin")
    */
    public function giveAdminRights(Request $request)
    {
        $user = $this->security->getUser();

        $messages = $this->userModel->addAdmin($user, $request);
        
        return new Response(json_encode($messages));
    }
}
