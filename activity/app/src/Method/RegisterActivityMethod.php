<?php

namespace App\Method;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Url;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use Exception;
use DateTimeImmutable;

class RegisterActivityMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    private const DATE_TIME_FORMAT = "d-m-Y H:i:s.u";

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function apply(array $paramList = null)
    {
        $activity = new Activity();
        $activity
            ->setUrl($paramList['url'])
            ->setVisitedAt(DateTimeImmutable::createFromFormat(self::DATE_TIME_FORMAT, $paramList['visitedAt']));

        try {
            $this->entityManager->persist($activity);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            return [
                'success' => true,
                'message' => $exception->getMessage()
            ];

        }

        return [
            'success' => true,
            'message' => "Посещение зафиксировано"
        ];
    }

    public function getParamsConstraint(): Constraint
    {
        return new Collection(['fields' => [
            'url' => new Required([
                new Length(['min' => 4, 'max' => 32]),
                new NotBlank(),
                new Url()

            ]),
            'visitedAt' => new Required([
                new DateTime(self::DATE_TIME_FORMAT),
                new NotBlank()
            ]),
        ]]);
    }
}