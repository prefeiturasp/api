<?php

namespace SuperMae\Silex;

use SuperMae\Silex\Gestations\Provider as GestationProvider;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends \Silex\Application
{
    public function setup()
    {
        $this->register(new MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__ . '/../../var/logs/supermae.log',
        ));
        $this->registerDatabase();
        $this->registerJsonContentAsArray();
        $this->register(new GestationProvider());
    }

    private function registerJsonContentAsArray()
    {
        $this->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });
    }

    private function registerDatabase()
    {
        $this['database_connection'] = $this->factory(function ($app) {
            $driverClass = $app['database.driver'];
            $reflection = new \ReflectionClass($driverClass);
            $driver = $reflection->newInstanceArgs($app['database.config']);

            return $driver;
        });
    }
}
