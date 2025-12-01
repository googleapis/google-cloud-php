<?php

namespace Google\Cloud\Dev\Command;

use Google\Cloud\Dev\Component;
use Google\Cloud\Dev\Packagist;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class VerifyReleaseCommand extends Command
{
    private Packagist $packagist;

    protected function configure()
    {
        $this->setName('verify-release')
            ->setDescription('Verifies the package version from packagist.')
            ->addOption(
                'component',
                'c',
                InputOption::VALUE_REQUIRED,
                'Get info for a single component'
            )
            ->addOption(
                'package-version',
                '',
                InputOption::VALUE_REQUIRED,
                'The version to check for'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->packagist = new Packagist(new Client(), '', '', null, $output);
        $components = Component::getComponents($input->getOption('component') ? [$input->getOption('component')] : []);
        $overrideVersion = $input->getOption('package-version');

        $notFound = [];
        foreach ($components as $component) {
            $packageName = $component->getPackageName();
            if (!($version = $overrideVersion) && !($version = $component->getComposerVersion())) {
                $version = 'v' . $component->getPackageVersion();
            }

            $output->write(sprintf('Verifying package <info>%s</info> version <info>%s</info>... ', $packageName, $version));
            if ($this->packagist->versionExists($packageName, $version)) {
                $output->writeln('<info>OK</info>');
            } else {
                $output->writeln('<error>NOT FOUND</error>');
                $notFound[] = $packageName . ':' . $version;
            }
        }

        if (count($notFound) > 0) {
            $output->writeln(sprintf('<error>%s package version(s) NOT FOUND</error>', count($notFound)));
            foreach ($notFound as $notFoundPackageName) {
                $output->writeln(sprintf('<error>%s</error>', $notFoundPackageName));
            }
            return 1;
        }

        return 0;
    }
}
