<?php

namespace SuperMae\Silex\Gestations;

use Psr\Log\LoggerInterface;
use SuperMae\Gestations\Filter;
use SuperMae\Silex\Gestations\Repositories\MongoDb;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Service
{
    /**
     * @var MongoDb
     */
    private $repository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Service constructor.
     *
     * @param MongoDb               $repository
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $logger
     */
    public function __construct(MongoDb $repository, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    public function statistics(Filter $filter)
    {
        return $this->repository->statistics($filter);
    }
}
