<?php

namespace App\Controller\User;

use App\Repository\TeamRepository;
use App\Entity\Team;
use App\Entity\Teammate;
use App\Entity\User;
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
    public function view(string $slug, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Team $team */
        $team =  $entityManager->getRepository(Team::class)->findOneBy(['slug' => $slug]);
        if(!$team) {
            throw new Exception('Team not found', 404);
        }

        /** @var User[] $other_users */
        $other_users = $entityManager->getRepository(User::class)->findExcludingTeam($team->getId());
        
        
        return $this->render('user/team/view.html.twig', [
            'user' => $user,
            'team' => $team,
            'other_users' => $other_users,
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
    public function delete(string $slug, Request $request, EntityManagerInterface $entityManager): Response
    {

        $submittedToken = $request->request->get('token');

        $result = array('success' => false);
        
        if (!$this->isCsrfTokenValid('delete-team', $submittedToken)) {
            $result['message'] = 'Invalid token or you cannot perform this action';
            return new Response(json_encode($result));

        }

        /**
         * @var Team $team
         */
        $team =  $entityManager->getRepository(Team::class)->findOneBy(['slug' => $slug]);

        if(!$team) {
            $result['message'] = 'Team doesn\'t exist';
        }
        else{
            $entityManager->getRepository(Team::class)->remove($team);
            $entityManager->flush();

            $result['success'] = true;
            $result['message'] = 'Team deleted successfully';
        }

        return new Response(json_encode($result));
    }

    #[Route('/app/teams/{slug}/teammate', name: 'app_teams_add_teammate', methods: ['POST'])]
    public function add_teammate(string $slug, Request $request, EntityManagerInterface $entityManager, TeamService $teamService): Response
    {

        $result = array('success' => false);
        
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('teammate-token', $submittedToken)) {
            $result['message'] = 'Invalid token or you cannot perform this action';
            return new Response(json_encode($result));

        }

        /**
         * @var Team $team
         */
        $team =  $entityManager->getRepository(Team::class)->findOneBy(['slug' => $slug]);

        if(!$team) {
            $result['message'] = 'Team doesn\'t exist';
            return new Response(json_encode($result));
        }
        

        /** @var User $user */
        $user2Add = $entityManager->getRepository(User::class)->find($request->request->get('user_id'));

        if(!$user2Add) {
            $result['message'] = 'The user doesn\'t exist';
            return new Response(json_encode($result));
        }

        // check if the user is not int the team yet
        if($teamService->checkIfUserIsATeam($team, $user2Add->getId())) {
            $result['message'] = 'The user is already in the team';
            return new Response(json_encode($result));
        }

        // get the new user role and verify is it is valid

        $newUserRole = $request->request->get('user_role');
        if($newUserRole!=='MASTER' && $newUserRole!=='WORKER') {
            $newUserRole = 'WORKER';
        }

        $newTeammate = (new Teammate())->setUser($user2Add)->setRole($newUserRole);
        $team->addTeammate($newTeammate);
        $entityManager->flush();

        $result['success'] = true;
        $result['message'] = $user2Add->getFullName()  . 'Has been added successfully';

        return new Response(json_encode($result));
    }

    #[Route('/app/teams/{slug}/teammate/{id}', name: 'app_teams_edit_teammate', methods: ['PUT'])]
    public function edit_teammate(string $slug, string $id, Request $request, EntityManagerInterface $entityManager, TeamService $teamService): Response
    {

        $result = array('success' => false);
        
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('teammate-token', $submittedToken)) {
            $result['message'] = 'Invalid token or you cannot perform this action';
            return new Response(json_encode($result));

        }

        /**
         * @var Team $team
         */
        $team =  $entityManager->getRepository(Team::class)->findOneBy(['slug' => $slug]);

        if(!$team) {
            $result['message'] = 'Team doesn\'t exist';
            return new Response(json_encode($result));
        }

        // get the teammate corresponding to the user and the team

        /** @var Teammate $teammate2Edit */
        $teammate2Edit = $entityManager->getRepository(Teammate::class)->find($id);
        if(!$teammate2Edit) {
            $result['message'] = 'The teammate doesn\'t exist';
            return new Response(json_encode($result));
        }

        $newUserRole = $request->request->get('user_role');
        if($newUserRole!=='worker' && $newUserRole!=='admin') {
            $newUserRole = 'worker';
        }

        $teammate2Edit->setRole($newUserRole);
        $entityManager->flush();

        $result['success'] = true;
        $result['message'] = $teammate2Edit->getUser()->getFullName()  . ' is now a ' . ucfirst($newUserRole);

        return new Response(json_encode($result));
    }

    #[Route('/app/teams/{slug}/teammate/{id}', name: 'app_teams_remove_teammate', methods: ['DELETE'])]
    public function remove_teammate(string $slug, string $id, Request $request, EntityManagerInterface $entityManager, TeamService $teamService): Response
    {
        $result = array('success' => false);
        
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('teammate-token', $submittedToken)) {
            $result['message'] = 'Invalid token or you cannot perform this action';
            return new Response(json_encode($result));

        }

        /**
         * @var Team $team
         */
        $team =  $entityManager->getRepository(Team::class)->findOneBy(['slug' => $slug]);

        if(!$team) {
            $result['message'] = 'Team doesn\'t exist';
            return new Response(json_encode($result));
        }

        // get the teammate corresponding to the user and the team

        /** @var Teammate $teammate2Remove */
        $teammate2Remove = $entityManager->getRepository(Teammate::class)->find($id);
        // check if the user is not int the team yet
        if(!$teammate2Remove) {
            $result['message'] = 'The user is not in the team';
            return new Response(json_encode($result));
        }

        
        $team->removeTeammate($teammate2Remove);
        $entityManager->getRepository(Teammate::class)->remove($teammate2Remove);
        $entityManager->flush();

        $result['success'] = true;
        $result['message'] = $teammate2Remove->getUser()?->getFullName()  . 'Has been removed successfully';

        return new Response(json_encode($result));
    }
}
