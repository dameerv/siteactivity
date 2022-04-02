<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Test4Controller extends AbstractController
{
    #[Route('/test4', name: 'app_test4')]
    public function index(): Response
    {
        return $this->render('test4/index.html.twig', [
            'controller_name' => 'Test4Controller',
        ]);
    }
}
