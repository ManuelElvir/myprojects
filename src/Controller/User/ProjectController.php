<?php

namespace App\Controller\User;

use App\Entity\Project;
use App\Entity\ProjectSetting;
use App\Entity\Status;
use App\Repository\TeamRepository;
use App\Entity\Team;
use App\Entity\Teammate;
use App\Entity\User;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/app/projects', name: 'app_projects', methods: ['GET'])]
    public function index(Request $request, ProjectRepository $projectRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $owner = $request->get('owner');
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $orderBy = $request->get('order');
        $orderDirection = $request->get('direction');

        $projects = $projectRepository->findByUser($user->getId(), orderBy: $orderBy, orderDirection: $orderDirection, limit: $limit, offset: $offset);

        return $this->render('user/project/index.html.twig', [
            'user' => $user,
            'projects' => $projects,
            'isOwned' => $owner === 'me'
        ]);
    }

    #[Route('/app/projects/{slug}', name: 'app_projects_view', methods: ['GET'])]
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

    #[Route('/app/projects/add', name: 'app_projects_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, TeamService $teamService): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $submittedToken = $request->request->get('token');
        $team = $request->request->get('team');

        if($request->getMethod()==='POST') {

            // just set up a fresh $task object (remove the example data)
            $project = new Project();

            $form = $this->createForm(ProjectType::class, $project);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $project->setTitle($form->get('title')->getData())
                ->setDescription($form->get('description')->getData())
                ->setOwner($user)
                ->setSlug($teamService->slugify($form->get('title')->getData()));

                // Add team if defined

                /** @var Team $team */
                $teamname = $form->get('team')->getData();
                $team = $entityManager->getRepository(Team::class)->findOneBy(array('slug' => $teamname));
                if($team && $team::class === Team::class) {
                    $project->setTeam($team);
                }

                // Add users if defined

                $users = $form->get('users')->getData();
                $usersArray = explode(',', $users);

                foreach ($usersArray as $userId) {
                    /** @var User $currentUser */
                    $currentUser = $entityManager->getRepository(User::class)->find($userId);
                    $project->addUser($currentUser);
                }


                $entityManager->persist($project);
                $projectSettings = new ProjectSetting();

                $status = $form->get('projectSetting.status')->getData();
                $statusArray = explode(',', $status);

                foreach ($statusArray as $statusItem) {
                    /**
                     * @var Status $currentStatus
                     */
                    $currentStatus = $entityManager->getRepository(Status::class)->findOneBy(['value' => $statusItem]);
                    $projectSettings->addProjectStatus($currentStatus);
                }

                $milestone_status = $form->get('projectSetting.milestone_status')->getData();
                $milestone_statusArray = explode(',', $milestone_status);

                foreach ($milestone_statusArray as $statusItem) {
                    /**
                     * @var Status $currentStatus
                     */
                    $currentStatus = $entityManager->getRepository(Status::class)->findOneBy(['value' => $statusItem]);
                    $projectSettings->addMilestoneStatus($currentStatus);
                }

                $task_status = $form->get('projectSetting.task_status')->getData();
                $task_statusArray = explode(',', $task_status);

                foreach ($task_statusArray as $statusItem) {
                    /**
                     * @var Status $currentStatus
                     */
                    $currentStatus = $entityManager->getRepository(Status::class)->findOneBy(['value' => $statusItem]);
                    $projectSettings->addTaskStatus($currentStatus);
                }
                
                $project->setProjectSetting($projectSettings);

            }
            return $this->redirectToRoute('app_projects_view', array('slug' => $project->getSlug()));
        }

        $teams = $entityManager->getRepository(Team::class)->findBy(['owner' => $user]);
        
        return $this->render('user/team/view.html.twig', [
            'user' => $user,
            'teams' => $teams,
        ]);
    }

    #[Route('/app/projects/{slug}/edit', name: 'app_projects_edit', methods: ['PUT', 'POST'])]
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

        return $this->redirectToRoute('app_projects_view', array('slug' => $team->getSlug()));
    }

    #[Route('/app/projects/{slug}', name: 'app_projects_delete', methods: ['DELETE'])]
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

    #[Route('/app/projects/{slug}/add_team', name: 'app_projects_add_team', methods: ['PATCH'])]
    public function add_team(string $slug, Request $request, TeamRepository $teamRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $result = array(
            'success' => false,
            'message' => 'You don\'t have permission to perform this action.'
        );

        return new Response(json_encode($result));
    }

    #[Route('/app/projects/{slug}/remove_team', name: 'app_projects_remove_team', methods: ['PATCH'])]
    public function remove_team(string $slug, Request $request, TeamRepository $teamRepository): Response
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
