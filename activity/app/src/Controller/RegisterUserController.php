<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class RegisterUserController extends AbstractController
{
    /**
     * Контроллер для создания тестового пользователя. В body добавить ключи email и  password.  Изменения, валидация
     * поьзователя и токена, а так же использование в продакшене контроллера не предусмотерно  так как проект
     * выполняется в  рамках тестового задания. Парль так же не хешируется по причине тествоого характера
     * проекта.
     *
     * @throws Exception
     */
    #[Route('/register-user', name: 'app_register_user', methods:['POST'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        try {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $apiToken = TokenGenerator::generate();

            if(!$email && !$password){
                throw new Exception('Поля  "email" и "password" обязательны');
            }

            $user = (new User())
                ->setEmail($email)
                ->setPassword($password)
                ->setRoles([User::API_ROLE])
                ->setApiToken($apiToken);

            $em->persist($user);
            $em->flush();

            return $this->json([
                "status" => 'success',
                'message' => 'Пользователь успешно зарегистрирован',
                'apiToken' => $user->getApiToken(),
            ]);
        } catch(Exception $e){

            return $this->json([
                "status" => "Error",
                'message' => $e->getMessage()
            ]);
        }

    }
}
