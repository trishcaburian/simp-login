<?php
namespace App\Models;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserModel
{
    private const ROLE_ADMIN = 'ROLE_ADMIN';
    private $entityManager, $passEncoder, $validator;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passEncoder, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->passEncoder = $passEncoder;
        $this->validator = $validator;
    }

    public function addUser(Request $request)
    {
        $message = '';
        $fields = $request->request->get('register');
        $username = $fields['username'];

        if ($this->isExistingUsername($username))
        {
            return 'Username already exists. Please use another.';
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($fields['password']);
        $user->setRoles(['ROLE_USER']);

        $errors = $this->validator->validate($user);

        if (count($errors) == 0) {
            $user->setPassword($this->passEncoder->encodePassword($user, $fields['password']));
            
            $this->entityManager->persist($user);

            $this->entityManager->flush();

            $message = "Added user: ".$fields['username'];
        }

        return $message;
    }

    public function addAdmin(User $requester, Request $request)
    {
        $messages = [];

        if (!in_array(self::ROLE_ADMIN, $requester->getRoles())) {
            array_push($messages, ['message' => 'You do not have access to this action.']);
            return $messages;
        }
        
        $users = $request->request->get('user');

        if(count($users) > 0) {
            for ($i=0; $i < count($users); $i++) { 
                $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $users[$i]]);

                $roles = $user->getRoles();

                if (in_array(self::ROLE_ADMIN, $roles)) {
                    array_push($messages, ['message' => $user->getUsername().' already has the Admin role!']);
                    continue;
                }

                array_push($roles, self::ROLE_ADMIN);
                $user->setRoles($roles);
                $this->entityManager->flush();

                array_push($messages, ['message' => $user->getUsername().' now has the Admin role!']);
            }
            return $messages;
        } else {
            return ['message' => NULL];
        }
    }

    public function getNonAdminUsers()
    {
        $sql = 'SELECT * FROM user WHERE roles NOT LIKE "%ROLE_ADMIN%"';

        return $this->genericSQL($sql);
    }

    private function isExistingUsername($username)
    {
        $result = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (!empty($result) || !is_null($result)) {
            return true;
        }

        return false;
    }

    private function genericSQL($sql)
    {
        $conn = $this->entityManager->getConnection();

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}