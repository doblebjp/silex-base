<?php

namespace SilexMax\Console;

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
        $dir = realpath($this->getProjectDirectory());

        if (!$dir) {
            throw new \RuntimeException("Invalid destination directory");
        }

        $dialog = $this->getHelperSet()->get('dialog');

        if (!$dialog->askConfirmation($output, "Update permissions in $dir ? (y/n) ")) {
            $output->writeln('Exiting');
            return;
        }

        $finder = new Finder();
        $finder
            ->in($dir)
            ->directories()
            ->depth(1)
            ->path('data/cache')
            ->path('data/log')
            ->path('data/sqlite')
            ->path('web/assets')
            ->sortByName();

        foreach ($finder as $dir) {
            $permission = substr(sprintf('%o', $dir->getPerms()), -4);

            $output->write($permission . ' ');

            if ('0777' === $permission) {
                $output->write('<comment>skip</comment>  ');
            } else {
                $output->write('<info>chmod</info> ');
                chmod($dir->getPathname(), 0777);
            }

            $output->writeln($dir->getRelativePathname());
        }
    }
}
