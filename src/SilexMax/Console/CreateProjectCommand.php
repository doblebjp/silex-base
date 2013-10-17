<?php

namespace SilexMax\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class CreateProjectCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('silex-max:project:create')
            ->setDescription('Create project')
            ->addArgument('dir', InputArgument::REQUIRED, 'Specify project root directory');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');
        if (strpos($dir, '/') !== 0) {
            $dir = getcwd() . '/' . $dir;
        }
        $dir = realpath($dir);

        if (!$dir) {
            throw new \RuntimeException("Invalid project directory");
        }

        $dialog = $this->getHelperSet()->get('dialog');

        if (!$dialog->askConfirmation($output, "Create project in $dir ? (y/n) ")) {
            $output->writeln('Exiting');
            return;
        }

        $finder = new Finder();
        $finder
            ->in(__DIR__ . '/../../../')
            ->ignoreVCS(false)
            ->notPath('/data\/(cache|log|sqlite)\/[^\.].+/')
            ->notName('composer.*')
            ->exclude('src/SilexMax')
            ->exclude('vendor')
            ->notPath('/web\/assets\/[^\.].+/')
            ->sortByName();

        foreach ($finder as $file) {
            $output->writeln($file->getRelativePathname());
        }

        $output->writeln("Project created at $dir");
    }
}
