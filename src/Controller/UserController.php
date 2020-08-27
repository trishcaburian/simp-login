<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
    *   @Route("/create_user", name="create_user")
    */
    public function createUser(Request $request)
    {

        $username = $request->request->get('reg_username');
        $password = $request->request->get('reg_password');

        // $user = new User();
        // $user->setUsername($username);
        // $user->setPassword($password);

        // $this->entityManager->persist($user);

        // $this->entityManager->flush();

        return new Response('added user '.$username);
    }
}
