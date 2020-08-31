<?php
namespace App\Controller;

use App\Models\UserModel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     *  @Route("/admin/dashboard", name="admin_page")
     */
    public function loadAdminDash()
    {
        $users = $this->userModel->getNonAdminUsers();

        return $this->render("pages/admin_dash.html.twig", [
            "users" => $users
        ]);
    }
}