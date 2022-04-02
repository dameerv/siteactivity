<?php

namespace App\Method;

use App\Repository\ActivityRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Required;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class ActivitiesMethod implements JsonRpcMethodInterface
{
    public function __construct(private ActivityRepository $repository)
    {
    }

    public function apply(array $paramList = null)
    {
        $pagination = $this->repository->getAllUrlsWithLastVisitPagination($paramList['page'], $paramList['itemsPerPage']);

        return [
            'page' => $pagination->getCurrentPageNumber(),
            'itemsPerPage' => $pagination->getItemNumberPerPage(),
            'items' => $pagination->getItems(),
            'totalItems' => $pagination->getTotalItemCount(),
            'totalPages' => (int)ceil($pagination->getTotalItemCount()/ $pagination->getItemNumberPerPage())
        ];
    }

    public function getParamsConstraint(): Constraint
    {
        return new Collection(['fields' => [
            'page' =>new Positive(),
            'itemsPerPage' => new Positive()
        ]]);
    }
}