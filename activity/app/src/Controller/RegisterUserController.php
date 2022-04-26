<?php

namespace App\Controller;

use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class RegisterUserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * Контроллер для создания тестового пользователя. В body добавить ключи email и  password.  Изменения, валидация
     * поьзователя и токена, а так же использование в продакшене контроллера не предусмотерно  так как проект
     * выполняется в  рамках тестового задания. Парль так же не хешируется по причине тествоого характера
     * проекта.
     *
     * @throws Exception
     */
    #[Route('/register-user', name: 'app_register_user', methods: ['POST'])]
    public function index(Request $request): Response
    {
        try {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if (!$email || !$password) {
                throw new Exception('Поля  "email" и "password" обязательны');
            }

            $user = UserService::createUser($email, $password);
            $this->em->persist($user);
            $this->em->flush();

            return $this->json([
                "status" => 'success',
                'message' => 'Пользователь успешно зарегистрирован',
                'apiToken' => $user->getApiToken(),
            ]);
        } catch (Exception $e) {
            return $this->json([
                "status" => "Error",
                'message' => $e->getMessage()
            ]);
        }
    }
}
