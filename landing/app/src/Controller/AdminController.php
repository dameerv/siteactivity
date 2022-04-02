<?php

namespace App\Controller;

use App\Service\ActivityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/{page}', name: 'app_admin', requirements:["page"=>"\d+"])]
    public function index(ActivityService $activityService, int $page = 1): Response
    {
        $pagination = $activityService->getPagination($page);

        return $this->render('admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
