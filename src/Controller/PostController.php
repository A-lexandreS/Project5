<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostController extends AbstractController
{
    #[Route('/dashboard/create-post')]
    public function createPost(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $originalFileName = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFileName = $slugger->slug($originalFileName);
                $newFilename = $safeFileName.'-'.uniqid().'.'.$picture->guessExtension();

                try {
                    $picture->move(
                        $this->getParameter('picture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $event->setPicture($newFilename);
            }

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
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_default_dashboard');
        }

        return $this->renderForm('post/changePost.html.twig', ['form' => $form]);
    }

    #[Route('/dashboard/delete-post/{id}')]
    public function deletePost(EntityManagerInterface $em, ManagerRegistry $doctrine, int $id): Response
    {
        $event = $doctrine->getRepository(Event::class)->find($id);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('app_default_dashboard');
    }
}
