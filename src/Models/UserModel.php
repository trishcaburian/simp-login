<?php
namespace App\Models;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserModel
{
    private $entityManager, $passEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passEncoder = $passEncoder;
    }

    public function addUser(Request $request)
    {
        $username = $request->request->get('reg_username');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passEncoder->encodePassword($user, $request->request->get('reg_password')));

        $this->entityManager->persist($user);

        $this->entityManager->flush();
    }
}