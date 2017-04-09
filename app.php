<?php

$application = new \SuperMae\Silex\Application($configuration);
$application->setup();

return $application;