<?php

namespace SilexBase\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SilexBase\Provider\TemplatingServiceProvider;

class CompileAssetsCommand extends Command
{
    public function configure()
    {
        $this->setName('app:compile-assets');
        $this->setDescription('Compile front-end assets to public directory');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        // Twig assets
        $output->write('<info>Building assets</info> ... ');
        $dumper = $app['assetic.dumper'];
        $dumper->addTwigAssets();
        $dumper->dumpAssets();
        $output->writeln('done');

        // Fonts
        $output->write('<info>Copying fonts</info> ..... ');
        $fontsDir = $app['assetic.path_to_web'] . '/assets/fonts';
        if (!file_exists($fontsDir) || !is_dir($fontsDir)) {
            mkdir($fontsDir);
        }
        foreach (glob($app['twbs_dir'] . '/fonts/glyphicons-halflings-regular.*') as $font) {
            copy($font, $fontsDir . '/' . basename($font));
        }
        $output->writeln('done');
    }
}
