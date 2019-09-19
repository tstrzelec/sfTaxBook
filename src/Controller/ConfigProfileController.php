<?php

namespace App\Controller;

use App\Entity\UsersProfiles;
use App\Form\ConfigProfileFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class ConfigProfileController extends AbstractController
{
    const CONFIGURED_USER = 'ROLE_CONFIGURED_USER';
    /**
     * @Route("/configpage", name="app_config")
     */
    public function configProfile(Request $request, RouterInterface $router, LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler)
    {
        $userProfile = new UsersProfiles;
        if (in_array(self::CONFIGURED_USER, $this->getUser()->getRoles())) {
            return new RedirectResponse($router->generate('app_homepage'));
        }
        $userProfile->setUserId($this->getUser()->getId());
        $this->getUser()->setRoles(['ROLE_CONFIGURED_USER']);


        $form = $this->createForm(ConfigProfileFormType::class, $userProfile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userProfile);
            $entityManager->flush();

            $user = $this->getUser();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('config\configpage.html.twig', [
            'ConfigProfileForm' => $form->createView(),
        ]);
    }
}
