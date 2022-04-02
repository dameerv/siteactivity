<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Test1Controller extends AbstractController
{
    #[Route('/test1', name: 'app_test1')]
    public function index(): Response
    {
        return $this->render('test1/index.html.twig', [
            'controller_name' => 'Test1Controller',
        ]);
    }
}
