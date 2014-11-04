<?php

namespace SilexBase\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class FileDirPermissionCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('silex-max:project:permission')
            ->setDescription('Setup file and directory permissions');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $projectDir = realpath($this->getProjectDirectory());

        if (!$projectDir) {
            throw new \RuntimeException("Invalid destination directory");
        }

        $dialog = $this->getHelperSet()->get('dialog');

        if (!$dialog->askConfirmation($output, "Update permissions in $projectDir ? (y/n) ")) {
            $output->writeln('Exiting');
            return;
        }

        $app = $this->getSilexApplication();

        $finder = new Finder();
        $finder
            ->in($projectDir)
            ->notPath('vendor')
            ->path(substr($app['cache_dir'], strlen($projectDir) + 1))
            ->path(substr($app['log_dir'], strlen($projectDir) + 1))
            ->path(substr($app['monolog.logfile'], strlen($projectDir) + 1))
            ->sortByName();

        if ($dialog->askConfirmation($output, 'Include public web assets? (y/n) ')) {
            $finder->path(substr($app['web_dir'], strlen($projectDir) + 1) . '/assets');
        }

        foreach ($finder as $file) {
            $permission = substr(sprintf('%o', $file->getPerms()), -4);

            $output->write($permission . ' ');

            if ($file->isFile()) {
                chmod($file->getPathname(), 0666);
                $output->write('<info>0666</info> ');
            } else {
                chmod($file->getPathname(), 0777);
                $output->write('<info>0777</info> ');
            }

            $output->writeln($file->getRelativePathname());
        }
    }
}
