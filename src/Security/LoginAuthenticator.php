<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class LoginAuthenticator extends AbstractGuardAuthenticator
{
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        
    }

    public function supports(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
   
        if (!empty($username) && !empty($password))
        {
            return true;
        }

        return false;
    }

    public function getCredentials(Request $request)
    {
        return [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = new User;
        $user->setUsername($credentials['username']);
        $user->setPassword($credentials['password']);
        $user->setIsLogin(true);
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $allowed_usernames = ['demo', 'testuser'];

        if ($credentials['password'] == 'demo' && in_array($credentials['username'], $allowed_usernames)) {
            return true;
        }
        return false;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $url = $this->router->generate('login_page');

        echo "<script>alert('Invalid User Details!')</script>";
        header("Location:". $url);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $url = $this->router->generate('homepage');

        return new RedirectResponse($url);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}