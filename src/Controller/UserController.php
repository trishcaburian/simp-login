<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

class UserController extends AbstractController
{
    private $entityManager, $passEncoder, $twigEnvironment;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passEncoder, Environment $twigEnvironment)
    {
        $this->entityManager = $entityManager;
        $this->passEncoder = $passEncoder;
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
    *   @Route("/create_user", name="create_user")
    */
    public function createUser(Request $request)
    {

        $username = $request->request->get('reg_username');
        $password = $request->request->get('reg_password');

        //add validation

        //shouldnt be in a controller
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passEncoder->encodePassword($user, $password));

        $this->entityManager->persist($user);

        $this->entityManager->flush();
        //end

        //return view or add msg on page
        $message = "Added user: ".$request->request->get('reg_username');; 
        return new Response($this->twigEnvironment->render('pages/register.html.twig', ['notification' => $message]));
    }
}
