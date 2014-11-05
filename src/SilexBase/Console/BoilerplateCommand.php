<?php

namespace SilexBase\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Finder\Finder;

class BoilerplateCommand extends Command
{
    public function configure()
    {
        $this->setName('app:boilerplate');
        $this->setDescription('Create project boilerplate');
        $this->addArgument('dir', InputArgument::REQUIRED, 'Specify destination directory');
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

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion("Create project in <info>$dir</info> (y/n)? ", false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('Exiting');
            return;
        }

        $finder = new Finder();
        $finder
            ->in(__DIR__ . '/../../..')
            ->ignoreDotFiles(false)
            // excluding some directories
            ->exclude('.vagrant')
            ->exclude('src/SilexBase')
            ->exclude('tests/SilexBase')
            ->exclude('vendor')
            // excluding these directory contents which are not dotfiles
            ->notPath('#data\/(cache|log|sqlite)\/[^\.].+#')
            ->notPath('#web\/assets\/[^\.].+#')
            ->notPath('#assets\/img\/.+#')
            // exclude files
            ->notName('composer.*')
            ->notName('*.md')
            ->notPath('#config\/local\.yml$#')
            // include files
            ->name('*')
            ->name('.gitignore')
            ->name('.htaccess')
            // skip existing files
            ->filter(function ($file) use ($dir) {
                $pathname = $dir . '/' . $file->getRelativePathname();
                $pathname = preg_replace('/\.dist$/', '', $pathname);
                return !file_exists($pathname);
            })
            ->sortByName();

        if (count($finder) === 0) {
            $output->writeln('Nothing to copy');
            return;
        }

        foreach ($finder as $file) {
            $pathname = $dir . '/' . $file->getRelativePathname();
            $pathname = preg_replace('/\.dist$/', '', $pathname);

            if ($file->isFile()) {
                $output->write('<info>copy</info>  ');
                copy($file->getPathname(), $pathname);
            } elseif ($file->isDir()) {
                $output->write('<info>mkdir</info> ');
                mkdir($pathname);
            } else {
                $output->write('<comment>skip</comment>  ');
            }

            $output->writeln($file->getRelativePathname());
        }

        $output->writeln("Project created at <info>$dir</info>");
    }
}
