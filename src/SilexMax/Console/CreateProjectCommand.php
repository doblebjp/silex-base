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
            ->addArgument('dir', InputArgument::REQUIRED, 'Specify destination directory');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');
        if (strpos($dir, '/') !== 0) {
            $dir = $this->getProjectDirectory() . '/' . $dir;
        }
        $dir = realpath($dir);

        if (!$dir) {
            throw new \RuntimeException("Invalid destination directory");
        }

        $dialog = $this->getHelperSet()->get('dialog');

        if (!$dialog->askConfirmation($output, "Create project in $dir ? (y/n) ")) {
            $output->writeln('Exiting');
            return;
        }

        $finder = new Finder();
        $finder
            ->in(__DIR__ . '/../../../')
            ->ignoreDotFiles(false)
              // excluding some directories
            ->exclude('src/SilexMax')
            ->exclude('vendor')
              // excluding these directory contents which are not dotfiles
            ->notPath('/data\/(cache|log|sqlite)\/[^\.].+/')
            ->notPath('/web\/assets\/[^\.].+/')
            ->notPath('bin/silex-max')
              // files
            ->notName('composer.*')
            ->name('.git*')
            ->name('.htaccess')
            ->name('*')
            ->sortByName();

        foreach ($finder as $file) {
            $pathname = $dir . '/' . $file->getRelativePathname();
            $pathname = preg_replace('/\.dist$/', '', $pathname);
            $exists = file_exists($pathname);

            if (!$exists) {
                if ($file->isFile()) {
                    $output->write('<info>copy</info>  ');
                    copy($file->getPathname(), $pathname);
                } elseif ($file->isDir()) {
                    $output->write('<info>mkdir</info> ');
                    mkdir($pathname);
                } else {
                    $output->write('<comment>skip</comment>  ');
                }
            } else {
               $output->write('<comment>skip</comment>  ');
            }

            $output->writeln($file->getRelativePathname());
        }

        $output->writeln("Project created at $dir");
    }
}
