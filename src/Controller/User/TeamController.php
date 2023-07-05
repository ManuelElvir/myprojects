<?php

namespace App\Controller\User;

use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/app/team', name: 'app_teams', methods: ['GET'])]
    public function index(Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $owner = $request->get('owner');
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $orderBy = $request->get('order');
        $orderDirection = $request->get('direction');

        $teams = [];

        if ($owner==="me") {
            $teams = $teamRepository->findBy(['owner_id' => $user->getId()]);
        }
        else {

            $userId = $user->getId();
            if(is_int($userId)) {
                $teams = $teamRepository->findByUser($userId);
            }
        }

        return $this->render('user/team/index.html.twig', [
            'user' => $user,
            'teams' => [0, 1, 2, 3, 4, 5, 6],
        ]);
    }

    #[Route('/app/teams/{teamId}', name: 'app_teams_view', methods: ['GET'])]
    public function view(int $teamId, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $team =  $teamRepository->find($teamId);
        if($team) {

        }
        
        return $this->render('user/team/view.html.twig', [
            'user' => $user,
            'team' => $team,
        ]);
    }

    #[Route('/app/teams/add', name: 'app_teams_add', methods: ['GET', 'POST'])]
    public function add(Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('user/team/edit.html.twig', [
            'user' => $user,
            'teams' => [0, 1, 2, 3, 4, 5, 6],
        ]);
    }

    #[Route('/app/teams/{teamId}/edit', name: 'app_teams_edit', methods: ['GET', 'PUT'])]
    public function edit(int $teamId, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('user/team/edit.html.twig', [
            'user' => $user,
            'teams' => [0, 1, 2, 3, 4, 5, 6],
        ]);
    }

    #[Route('/app/teams/{teamId}', name: 'app_teams_delete', methods: ['DELETE'])]
    public function delete(int $teamId, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $result = array(
            'success' => false,
            'message' => 'You don\'t have permission to perform this action.'
        );

        return new Response(json_encode($result));
    }

    #[Route('/app/teams/{teamId}/add_teammate', name: 'app_teams_add_teammate', methods: ['PATCH'])]
    public function add_teammate(int $teamId, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $result = array(
            'success' => false,
            'message' => 'You don\'t have permission to perform this action.'
        );

        return new Response(json_encode($result));
    }

    #[Route('/app/teams/{teamId}/remove_teammate', name: 'app_teams_remove_teammate', methods: ['PATCH'])]
    public function remove_teammate(int $teamId, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $result = array(
            'success' => false,
            'message' => 'You don\'t have permission to perform this action.'
        );

        return new Response(json_encode($result));
    }
}
