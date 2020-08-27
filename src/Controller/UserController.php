<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $entityManager, $passEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passEncoder = $passEncoder;
    }

    /**
    *   @Route("/create_user", name="create_user")
    */
    public function createUser(Request $request)
    {

        $username = $request->request->get('reg_username');
        $password = $request->request->get('reg_password');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);

        $this->entityManager->flush();

        return new Response('added user '.$username);
    }
}
