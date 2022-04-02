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

class TestController extends AbstractController
{
    /**
     * Контроллер для создания тестового пользователя. В body добавить ключи email и  password.  Изменения, валидация
     * поьзователя и токена, а так же использование в продакшене контроллера не предусмотерно  так как проект
     * выполняется в  рамках тестового задания. Парль так же не хешируется по причине тествоого характера
     * проекта.
     *
     * @throws Exception
     */
    #[Route('/test', name: 'test', methods:['POST'])]
    public function index(Request $request, ActivityRepository $activityRepository): Response
    {
        dd(
            $activityRepository->getAllUrlsWithLastVisitPagination()
        );


    }
}
