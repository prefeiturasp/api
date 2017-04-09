<?php

namespace SuperMae\Silex\Gestations;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use SuperMae\Silex\Application;

class Provider implements ServiceProviderInterface
{
    public function register(Container $application)
    {
        $application['supermae_gestations_repository'] = $application->factory(function ($app) {
            $repositoryClass = $app['supermae.gestations.repository.class'];
            $reflectionClass = new \ReflectionClass($repositoryClass);

            return $reflectionClass->newInstanceArgs([
                $app['database_connection'],
                $app['monolog']
            ]);
        });
        $application['supermae_gestations_service'] = $application->factory(function ($app) {
            return new Service($app['supermae_gestations_repository'], $app['dispatcher'], $app['monolog']);
        });
        $application['supermae_gestations_controller'] = $application->factory(function ($app) {
            return new Controller($app['supermae_gestations_service'], $app['supermae_gestations_repository']);
        });
        $this->registerRoutes($application);
    }

    private function registerRoutes(Application $application)
    {
        $application->get('/', [$application['supermae_gestations_controller'], 'status']);
        $application->options('/gestations', [$application['supermae_gestations_controller'], 'options']);
        $application->post('/gestations', [$application['supermae_gestations_controller'], 'statistics']);
    }
}
