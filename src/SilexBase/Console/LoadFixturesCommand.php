<?php

namespace SilexBase\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use SilexBase\Provider\OrmServiceProvider;

class LoadFixturesCommand extends Command
{
    public function configure()
    {
        $this->setName('app:load-fixtures');
        $this->setDescription('Load ORM fixtures from directory');
        $this->addArgument('dir', InputArgument::REQUIRED, 'Specify fixtures directory');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = realpath($input->getArgument('dir'));

        if (!$dir) {
            throw new \RuntimeException("Invalid destination directory");
        }

        $app = $this->getSilexApplication();
        $app->register(new OrmServiceProvider());

        $em = $app['orm.em'];
        $schemaTool = new SchemaTool($em);
        $loader = new Loader();
        $executor = new ORMExecutor($em, new ORMPurger());

        $loader->loadFromDirectory($dir);
        $executor->execute($loader->getFixtures());

        $output->writeln("Loaded fixtures from $dir");
    }
}
