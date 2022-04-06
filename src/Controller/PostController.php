<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response as FlexResponse;

class PostController extends AbstractController
{
    #[Route('/dashboard/create-post')]
    public function createPost(Request $request, EntityManagerInterface $em): Response
    { 

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($event);

            $em->flush();
            return $this->redirectToRoute('app_default_dashboard');
        }
        return $this->renderForm('post/createPost.html.twig', ['form' => $form]);
    }
    
    #[Route('/dashboard/change-post/{id}')]
    public function changePost(Request $request, EntityManagerInterface $em, ManagerRegistry $doctrine, int $id): Response
    {
        $event = $doctrine->getRepository(Event::class)->find($id);
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('app_default_dashboard');
        }
        return $this->renderForm('post/changePost.html.twig', ['form' => $form]);
    }
    #[Route('/dashboard/delete-post/{id}')]
    public function deletePost(EntityManagerInterface $em,ManagerRegistry $doctrine, int $id): Response
    {
        $event = $doctrine->getRepository(Event::class)->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('app_default_dashboard');
    }
}
