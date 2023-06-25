<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FileController extends AbstractController
{
    #[Route('/admin/files', name: 'app_admin_file')]
    // #[IsGranted("ROLE_ADMIN")]
    public function index(): Response
    {
        return $this->render('admin/file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }
}
