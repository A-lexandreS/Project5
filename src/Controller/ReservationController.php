<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function reservation(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('Name', TextType::class)
            ->add('FirstName', TextType::class)
            ->add('Email', EmailType::class)
            ->add('tickets', TypeIntegerType::class)
            ->add('submit' , SubmitType::class, ['label' => 'Envoyez'])
            ->getForm()
        ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            dd('traitement');
        }

        return $this->render('reservation/reservation.html.twig', ['Reservation' => $form->createview()]);
    }
}
