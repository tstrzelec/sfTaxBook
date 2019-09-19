<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    const CONFIGURED_USER = 'ROLE_CONFIGURED_USER';
    private $router;
    private $tokenStorageInterface;

    public function __construct(RouterInterface $router, TokenStorageInterface $tokenStorageInterface) {
        $this->router = $router;
        $this->tokenStorage = $tokenStorageInterface;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        if(empty($this->tokenStorageInterface) || !in_array(self::CONFIGURED_USER, $this->tokenStorageInterface->getToken()->getRoleNames()))
        {
            return new RedirectResponse($this->router->generate('app_config'));
        }

    }
}