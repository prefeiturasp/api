<?php

namespace SuperMae\Silex\Gestations;

use SuperMae\Gestations\Filter;
use SuperMae\Silex\Gestations\Repositories\MongoDb;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    /**
     * @var Service
     */
    private $service;

    /**
     * @var MongoDb
     */
    private $userRepository;

    /**
     * Urls constructor.
     *
     * @param Service $service
     * @param MongoDb $repository
     */
    public function __construct(Service $service, MongoDb $repository)
    {
        $this->service = $service;
        $this->userRepository = $repository;
    }

    public function status()
    {
        return new JsonResponse(['status' => 'available'], JsonResponse::HTTP_OK);
    }

    public function statistics(Request $request)
    {
        $age = $request->request->get('age');
        $statistics = $this->service->statistics(
            new Filter(
                new Filter\AgeRange(
                    $request->request->get('age_from', $age),
                    $request->request->get('age_to', $age)
                ),
                $request->request->get('unit'),
                $request->request->get('week'),
                $request->request->get('robson_group')
            )
        );

        return new JsonResponse(['units' => $statistics], JsonResponse::HTTP_OK);
    }

}
