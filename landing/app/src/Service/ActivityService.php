<?php

namespace App\Service;

use App\Entity\Activity;
use Exception;
use DateTimeImmutable;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ActivityService
{
    public function __construct(
        private ActivityHttpClient $client,
        private int                $itemsPerPage,
        private PaginatorInterface $paginator)
    {

    }

    /**
     * @param int $page
     * @return PaginationInterface|null
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getPagination(int $page = 1): ?PaginationInterface
    {
        $response = $this->client->send('activities', [
            'page' => $page,
            'itemsPerPage' => $this->itemsPerPage
        ]);
        $entities = [];

        if ($response->getStatusCode() === 200) {
            $activities = json_decode($response->getContent())[0]->result;

            $firstItem = $page * $this->itemsPerPage - $this->itemsPerPage;
            $lastItem = $firstItem + count($activities->items) - 1;

            $itemIndex = 0;

            for ($i = 0; $i < $activities->totalItems; $i++) {
                if ($i >= ($firstItem) && $i <= ($lastItem)) {
                    $item = $activities->items[$itemIndex];

                    $entity = $this->createActivities($item, $i);
                    $entities[$i] = $entity;
                    $itemIndex++;
                } else {
                    $entities[$i] = [];
                }

            }

            $pagination = $this->paginator->paginate($entities, $page, $this->itemsPerPage);

            $pagination->setTotalItemCount($activities->totalItems);
            $pagination->setItems($entities);
            return $pagination;

        }

        return null;

    }

    private function createActivities(object $item, $id)
    {

        $entity = new Activity();
        $entity->setId($id);
        $entity->setUrl($item->url);
        $entity->setNumberOfVisits($item->numberOfVisits);
        $entity->setLastVisit(new DateTimeImmutable($item->lastVisit));

        return $entity;
    }
}