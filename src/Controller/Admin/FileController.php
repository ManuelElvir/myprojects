<?php

namespace App\Controller\Admin;

use App\Entity\File;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FileController extends AbstractController
{
    #[Route('/admin/files', name: 'app_admin_file')]
    // #[IsGranted("ROLE_ADMIN")]
    public function index(Request $request, FileRepository $fileRepository): Response
    {

        $project = (int) $request->query->get('project');
        $user = $request->query->get('user');
        $keyword = $request->query->get('keyword');
        $page = (int) $request->query->get('page');
        $limit = (int) $request->query->get('limit');
        $orderBy = $request->query->get('orderBy');
        $orderDirection = $request->query->get('orderDirection');
        $fileType = $request->query->get('fileType');

        $filters = [];
        if ($project) {
            $filters[] = "t.project_id = $project";
        }
        if ($user) {
            $filters[] = "f.owner_id = $user";
        }
        if ($keyword) {
            $filters[] = "f.file_name LIKE '%$keyword%'";
        }

        $offset = null;
        if ($page && $limit) {
            $offset = ($page - 1) * $limit;
        }
        $files = $fileRepository->findSQLFiltersPaginated($filters, $orderBy, $orderDirection, $limit, $offset);


        return $this->render('admin/file/index.html.twig', [
            'files' => $files,
        ]);
    }

    #[Route('/admin/file/${id}/delete', name: 'app_admin_file_delete')]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(string $id, FileRepository $fileRepository): Response
    {
        /**
         * @var File $file
         */
        $file = $fileRepository->find($id);

        $result = array(
            'success' => true,
            'message' => 'File deleted successfully',
        );

        if(!$file) {
            $result['message'] = 'File not found';
            $result['success'] = false;
            return new Response(json_encode($result), Response::HTTP_OK);
        }

        $fileRepository->remove($file, true);

        return new Response(json_encode($result), Response::HTTP_OK);
    }
}
