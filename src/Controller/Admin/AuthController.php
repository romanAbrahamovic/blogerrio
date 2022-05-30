<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthController
 * @package Admin\Controller
 */
#[Route('/admin')]
class AuthController extends AbstractController
{
    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: 'app_admin_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->isGranted(User::USER_ROLES['ROLE_ADMIN'])) {
            return $this->redirectToRoute('app_admin_comment_index');
        }

        return $this->render(
            'admin/login/authLoginForm.html.twig',
            [
                'lastUsername' => $authenticationUtils->getLastUsername(),
                'error' => $authenticationUtils->getLastAuthenticationError()
            ]
        );
    }

    #[Route('/logout', name: 'app_admin_logout', methods: ['GET'])]
    public function logout(): void
    {
    }
}
