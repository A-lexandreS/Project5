<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/dashboard/create-post', name: 'create-post')]
    public function createPost(Request $request): Response
    { 
        





        return $this->render('post/createPost.html.twig', []);
    }
}
