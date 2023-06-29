<?php

namespace App\Controller\User;

use App\Message\NewUserMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/app', name: 'app_home')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        
        return $this->render('user/dashboard/index.html.twig', [
            'user' => $user,
            'tasks' => [1, 2, 3, 4, 5],
            'activities' => [1, 2, 3, 4, 5, 6, 7, 8],
            'milestones' => [1, 2],
        ]);
    }

    #[Route('/app/stats', name: 'app_stats')]
    public function stats(): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('user/dashboard/stats.html.twig', []);
    }
}
