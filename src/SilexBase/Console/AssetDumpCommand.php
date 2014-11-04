<?php

namespace SilexBase\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SilexBase\Provider\TemplatingServiceProvider;

class AssetDumpCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('silex-max:asset:dump')
            ->setDescription('Compile and dump all assets to public directory');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        // Twig assets
        $output->write('Building assets ... ');
        $dumper = $app['assetic.dumper'];
        $dumper->addTwigAssets();
        $dumper->dumpAssets();
        $output->writeln('Done');

        // Fonts
        $output->write('Copying fonts ... ');
        $fontsDir = $app['assetic.path_to_web'] . '/assets/fonts';
        if (!file_exists($fontsDir) || !is_dir($fontsDir)) {
            mkdir($fontsDir);
        }
        foreach (glob($app['twbs_dir'] . '/fonts/glyphicons-halflings-regular.*') as $font) {
            copy($font, $fontsDir . '/' . basename($font));
        }
        $output->writeln('Done');
    }
}
