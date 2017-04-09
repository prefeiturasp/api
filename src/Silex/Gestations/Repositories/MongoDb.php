<?php

namespace SuperMae\Silex\Gestations\Repositories;

use MongoDB\Client;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;
use Psr\Log\LoggerInterface;
use SuperMae\Coordinates;
use SuperMae\Establishments\Statistic;
use SuperMae\Gestation;
use SuperMae\Gestations\Filter;

class MongoDb
{
    const DATABASE_NAME = 'supermae';

    const COLLECTION_NAME = 'gestations';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var \MongoDB\Collection
     */
    private $collection;

    /**
     * SqlRepository constructor.
     *
     * @param Client $client
     * @param LoggerInterface $logger
     */
    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->database = $client->selectDatabase(self::DATABASE_NAME);
        $this->collection = $this->database->selectCollection(self::COLLECTION_NAME);
        $this->logger = $logger;
    }

    public function insert(Gestation $gestation)
    {
        $this->collection->insertOne(json_decode(json_encode($gestation), true));
        $this->logger->info('a new gestation was added');
    }

    public function statistics(Filter $filter)
    {
        $pipeline = [];
        if ($filter->isNotEmpty()) {
            $pipeline[] = ['$match' => $filter->toArray()];
        }
        $pipeline[] = [
            '$group' => [
                '_id' => [
                    'id' => '$establishment.id',
                    'name' => '$establishment.name',
                    'coordinates' => '$establishment.address.coordinates'
                ],
                'totalMothers' => ['$sum' => 1]
            ]
        ];
        $pipeline[] = [
            '$project' => [
                '_id' => '$_id.id',
                'name' => '$_id.name',
                'coordinates' => '$_id.coordinates',
                'totalMothers' => '$totalMothers'
            ]
        ];

        $result = $this->collection->aggregate($pipeline);

        return array_map(function (BSONDocument $document) {
            $establishment = $document->getArrayCopy();
            $coordinates= $establishment['coordinates'];
            return new Statistic(
                $establishment['name'],
                new Coordinates(
                    $coordinates->offsetGet('latitude'),
                    $coordinates->offsetGet('longitude')
                ),
                $establishment['totalMothers']
            );
        }, iterator_to_array($result));
    }
}
