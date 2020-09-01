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
    *   @Route("/create_user", name="create_user", condition="request.isXmlHttpRequest()")
    */
    public function createUser(Request $request)
    {
        $messages = $this->userModel->addUser($request);

        return $this->render('mini/message.html.twig', ['messages' => $messages]);
    }

    /**
    *   @Route("/admin/add_user_admin", name="add_user_admin", condition="request.isXmlHttpRequest()")
    */
    public function giveAdminRights(Request $request)
    {
        $user = $this->security->getUser();

        $messages = $this->userModel->addAdmin($user, $request);
        
        return $this->render('mini/message.html.twig', ['messages' => $messages]);;
    }
}
