<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ActivityRepository;
use App\Security\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods:['GET'])]
    public function index(Request $request, ActivityRepository $activityRepository): Response
    {
        return new Response('Home');
    }
}
