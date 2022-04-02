<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Test5Controller extends AbstractController
{
    #[Route('/test5', name: 'app_test5')]
    public function index(): Response
    {
        return $this->render('test5/index.html.twig', [
            'controller_name' => 'Test5Controller',
        ]);
    }
}
