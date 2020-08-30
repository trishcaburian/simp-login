<?php
namespace App\Models;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserModel
{
    private $entityManager, $passEncoder, $validator;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passEncoder, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->passEncoder = $passEncoder;
        $this->validator = $validator;
    }

    public function addUser(Request $request)
    {
        $messages =[];

        $username = $request->request->get('reg_username');

        if ($this->isExistingUsername($username))
        {
            array_push($messages, ['message' => 'Username already exists. Please use another.']);
            return $messages;
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($request->request->get('reg_password'));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $messages = $errors;
        } else {
            $user->setPassword($this->passEncoder->encodePassword($user, $request->request->get('reg_password')));
            
            $this->entityManager->persist($user);

            $this->entityManager->flush();

            array_push($messages, ['message' => "Added user: ".$request->request->get('reg_username')]);
        }

        return $messages;
    }

    public function addAdmin(User $requester, Request $request)
    {
        $messages = [];

        if (!in_array('ROLE_ADMIN', $requester->getRoles())) {
            array_push($messages, ['message' => 'You do not have access to this action.']);
            return $messages;
        }
    }

    private function isExistingUsername($username)
    {
        $result = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (!empty($result) || !is_null($result)) {
            return true;
        }

        return false;
    }
}