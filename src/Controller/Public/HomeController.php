<?php

namespace App\Controller\Public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'public_home')]
    public function index(): Response
    {
        return $this->render('public/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'public_contact')]
    public function contact(): Response
    {
        return $this->render('public/home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
