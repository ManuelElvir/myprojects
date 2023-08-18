<?php

namespace App\Controller\User;

use App\Repository\TeamRepository;
use App\Entity\Team;
use App\Entity\Teammate;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/app/teams', name: 'app_teams', methods: ['GET'])]
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
            $teams = $teamRepository->findBy(['owner' => $user]);
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
            'isOwned' => $owner === 'me'
        ]);
    }

    #[Route('/app/teams/{slug}', name: 'app_teams_view', methods: ['GET'])]
    public function view(string $slug, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $team =  $teamRepository->findOneBy(['slug' => $slug]);
        if(!$team) {
            throw new Exception('Team not found', 404);
        }
        
        return $this->render('user/team/view.html.twig', [
            'user' => $user,
            'team' => $team,
        ]);
    }

    #[Route('/app/teams/add', name: 'app_teams_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
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
        $team->setTeamName($teamName)
            ->setOwner($user)
            ->setSlug(TeamService::slugify($teamName));
        $entityManager->persist($team);

        // Save the first teammate
        /**
         * @var Teammate $teammate
         */
        $teammate = new Teammate();
        $teammate->setTeam($team)
            ->setUser($user)
            ->setRole('admin');

        $entityManager->persist($teammate);
        $entityManager->flush();


        return $this->redirectToRoute('app_teams_view', array('teamId' => $team->getId()));
    }

    #[Route('/app/teams/{slug}/edit', name: 'app_teams_edit', methods: ['PUT', 'POST'])]
    public function edit(string $slug, Request $request, EntityManagerInterface $entityManager, TeamService $teamService): Response
    {
        $submittedToken = $request->request->get('token');
        $teamName = $request->request->get('team_name');

        // $result = array('success' => false);
        
        if (!$this->isCsrfTokenValid('edit-team', $submittedToken)) {
            $this->addFlash('error', 'Invalid token or you cannot perform this action');
            // $result['message'] = array('type' => 'error', 'message' => 'Invalid token or you cannot perform this action');
            // return new Response(json_encode($result));

            return $this->redirectToRoute('app_teams_view', array('slug' => $slug));
        }

        /**
         * @var Team $team
         */
        $team =  $entityManager->getRepository(Team::class)->findOneBy(['slug' => $slug]);

        if(!$team) {
            throw new Exception('Team not found', 404);
        }

        if($teamService->slugExists($teamName)) {
            $this->addFlash('error', 'This team name already exists');
            return $this->redirectToRoute('app_teams_view', array('slug' => $slug));
        }
        
        if($team::class === Team::class) {
            $team->setTeamName($teamName);
            $team->setSlug(TeamService::slugify($teamName));
            $entityManager->flush();
        }
            
        $this->addFlash('success', 'Team updated successfully');

        return $this->redirectToRoute('app_teams_view', array('slug' => $team->getSlug()));
    }

    #[Route('/app/teams/{slug}', name: 'app_teams_delete', methods: ['DELETE'])]
    public function delete(string $slug, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $result = array(
            'success' => false,
            'message' => 'You don\'t have permission to perform this action.'
        );

        return new Response(json_encode($result));
    }

    #[Route('/app/teams/{slug}/add_teammate', name: 'app_teams_add_teammate', methods: ['PATCH'])]
    public function add_teammate(string $slug, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $result = array(
            'success' => false,
            'message' => 'You don\'t have permission to perform this action.'
        );

        return new Response(json_encode($result));
    }

    #[Route('/app/teams/{slug}/remove_teammate', name: 'app_teams_remove_teammate', methods: ['PATCH'])]
    public function remove_teammate(string $slug, Request $request, TeamRepository $teamRepository): Response
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
