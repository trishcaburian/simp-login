<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

use Twig\Environment;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $twigEnvironment;

    public function __construct(Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $message = "Sorry, this page is off limits! :(";
        return new Response($this->twigEnvironment->render('errors/default.html.twig', ['error_message' => $message]), 403);
    }
}