<?php

namespace App\Controller\User;

use App\Repository\TeamRepository;
use App\Entity\Team;
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
                $teams = $teamRepository->findByUser($userId, orderBy: $orderBy, orderDirection: $orderDirection, limit: $limit, offset: $offset);
            }
        }

        return $this->render('user/team/index.html.twig', [
            'user' => $user,
            'teams' => $teams,
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

        $submittedToken = $request->request->get('token');
        $teamName = $request->request->get('team_name');
        
        if (!$this->isCsrfTokenValid('add-team', $submittedToken)) {
            $this->addFlash('error', 'Invalid token or you cannot perform this action');
            return $this->redirectToRoute('app_teams');
        }

         /**
         * @var Team $team
         */
        $team = new Team();
        $team->setTeamName($teamName);
        $team->setOwner($user);
        $teamRepository->save($team, true);
        return $this->redirectToRoute('app_teams_view', array('teamId' => $team->getId()));
    }

    #[Route('/app/teams/{teamId}/edit', name: 'app_teams_edit', methods: ['PUT'])]
    public function edit(int $teamId, Request $request, TeamRepository $teamRepository): Response
    {
        $submittedToken = $request->request->get('token');
        $teamName = $request->request->get('team_name');

        $result = array('success' => false);
        
        if (!$this->isCsrfTokenValid('edit-team', $submittedToken)) {
            // $this->addFlash('error', 'Invalid token or you cannot perform this action');
            $result['message'] = array('type' => 'error', 'message' => 'Invalid token or you cannot perform this action');
            return new Response(json_encode($result), );
        }

        /**
         * @var Team $team
         */
        $team = $teamRepository->find($teamId);
        if($team::class === Team::class){
            $team->setTeamName($teamName);
            $teamRepository->flush();
        }

        return $this->redirectToRoute('app_teams_view');
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
