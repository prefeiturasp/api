<?php

namespace SuperMae\Console\Commands;

use SuperMae\Silex\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Installation extends Command
{
    /**
     * @var Application
     */
    private $application;

    public function __construct(Application $application)
    {
        parent::__construct('supermae:install');
        $this->application = $application;
    }

    protected function configure()
    {
        $this
            ->setDescription('Install SuperMãe Application.')
            ->setHelp("This command will run database query...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $resources = new \DirectoryIterator($this->application['supermae.resources.sql.path']);

        $filteredResources = new \CallbackFilterIterator($resources, function (\DirectoryIterator $resource) {
            return !$resource->isDot();
        });

        /** @var \PDO $dbConnection */
        $dbConnection = $this->application['database_connection'];

        /** @var \DirectoryIterator $resource */
        foreach ($filteredResources as $resource) {
            $tableName = $resource->getBasename('');
            $output->write("{$tableName}");
            $statement = file_get_contents($resource->getRealPath());
            $dbConnection->query($statement);
            $output->writeln(" ... OK");
        }
    }
}
