<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/login')]
    public function login(): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        return $this->renderForm('user/login.html.twig', ['form' => $form]);
    }
}
