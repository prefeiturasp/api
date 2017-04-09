<?php

namespace SuperMae\Console\Commands;

use SuperMae\Gestations\PelvicPresentation;
use SuperMae\Silex\Application;
use SuperMae\Silex\Gestations\Repositories\MongoDb;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SuperMae\Address;
use SuperMae\Coordinates;
use SuperMae\Gestation;
use SuperMae\ChildbirthType;
use SuperMae\Establishment;
use SuperMae\Gender;
use SuperMae\Mother;
use SuperMae\Pregnancy;

class GestationImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gestation:import {child} {establishment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Gestation from CSV';

    /**
     * @var Establishment[]
     */
    protected $establishments = [];

    /**
     * @var Application
     */
    private $application;

    public function __construct(Application $application)
    {
        parent::__construct('gestation:import');
        $this->application = $application;
    }

    protected function configure()
    {
        $this
            ->setDescription('Install SuperMãe Application.')
            ->setHelp("This command will run database query...");
        $this->addArgument('gestation_file');
        $this->addArgument('establishment_file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $gestationFile = $input->getArgument('gestation_file');

        /** @var MongoDb $collection */
        $repository = $this->application['supermae_gestations_repository'];

        $skipFirst = true;
        if (($handle = fopen($gestationFile, "r")) !== false) {
            while (($data = fgetcsv($handle, 4000, ",")) !== false) {
                if ($skipFirst) {
                    $skipFirst = false;
                    continue;
                }
                $CODESTAB = $data[0];
                $CODMUNESTB = $data[1];
                $CODMUNNASC = $data[2];
                $IDADEMAE = $data[3];
                $ESCMAE = $data[4];
                $GRAVIDEZ = $data[6];
                $PARTO = $data[7];
                $DTNASC = \DateTime::createFromFormat('dmY', str_pad($data[8], 8, 0, STR_PAD_LEFT));
                $SEXO = $data[9];
                $APGAR5 = $data[10];
                $RACACOR = $data[11];
                $PESO = $data[12];
                $ESCMAE2010 = $data[13];
                $RACACORMAE = $data[14];
                $QTDPARTNOR = $data[15];
                $QTDPARTCES = $data[16];
                $SEMAGESTAC = $data[17];
                $TPAPRESENT = $data[18];
                $STTRABPART = $data[19];
                $STCESPARTO = $data[20];
                $TPROBSON = $data[21];

                $mother = new Mother(
                    $IDADEMAE,
                    new Pregnancy($GRAVIDEZ),
                    $QTDPARTCES,
                    $QTDPARTNOR,
                    $SEMAGESTAC,
                    new PelvicPresentation($TPAPRESENT),
                    $TPROBSON
                );

                $establishment = $this->findOneEstablishment($input, $CODESTAB);

                if (!$establishment) {
                    continue;
                }

                $gestation = new Gestation(
                    $establishment,
                    new ChildbirthType($PARTO),
                    $mother,
                    $DTNASC,
                    new Gender($SEXO),
                    $PESO,
                    $STTRABPART,
                    $STCESPARTO,
                    $TPROBSON
                );

                $repository->insert($gestation);
            }
            fclose($handle);
        }
        return null;
    }

    /**
     * Find Establishment by ID.
     * @param int $establishmentId
     * @return Establishment
     */
    private function findOneEstablishment(InputInterface $input, $establishmentId)
    {
        $establishment = $input->getArgument('establishment_file');
        if (empty($this->establishments) && ($handle = fopen($establishment, "r")) !== false) {
            $skipFirst = true;
            while (($data = fgetcsv($handle, 4000, ",")) !== false) {
                if ($skipFirst) {
                    $skipFirst = false;
                    continue;
                }
                $coordinates = new Coordinates(str_replace(',', '.', $data[17]), str_replace(',', '.', $data[18]));
                $address = new Address($data[11], $data[9], $data[10], $data[12], $coordinates);
                $establishment = new Establishment($data[4], $data[5], $data[6], $address);
                $this->establishments[$establishment->id] = $establishment;
            }
        }
        return $this->establishments[$establishmentId] ?? null;
    }
}
