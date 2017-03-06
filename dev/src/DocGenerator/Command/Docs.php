<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev\DocGenerator\Command;

use Google\Cloud\Dev\DocGenerator\DocGenerator;
use Google\Cloud\Dev\DocGenerator\GuideGenerator;
use Google\Cloud\Dev\DocGenerator\TableOfContents;
use Google\Cloud\Dev\DocGenerator\TypeGenerator;
use Google\Cloud\Dev\GetComponentsTrait;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Docs extends Command
{
    use GetComponentsTrait;

    const DEFAULT_OUTPUT_DIR = 'docs/json';
    const TOC_SOURCE_DIR = 'docs/contents';
    const TOC_TEMPLATE = 'docs/toc.json';
    const DEFAULT_SOURCE_DIR = 'src';

    private $cliBasePath;

    public function __construct($cliBasePath)
    {
        $this->cliBasePath = $cliBasePath;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('docs')
            ->setDescription('Generate Documentation')
            ->addOption('release', 'r', InputOption::VALUE_REQUIRED, 'If set, docs will be generated into tag folders' .
                ' such as v1.0.0 rather than master.', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $release = ($input->getOption('release') === false) ? false : true;

        $paths = [
            'source' => $this->cliBasePath .'/../'. self::DEFAULT_SOURCE_DIR,
            'output' => $this->cliBasePath .'/../'. self::DEFAULT_OUTPUT_DIR,
            'project' => $this->cliBasePath .'/../',
            'manifest' => $this->cliBasePath .'/../docs/manifest.json',
            'toc' => $this->cliBasePath .'/../'. self::TOC_SOURCE_DIR,
            'tocTemplate' => $this->cliBasePath .'/../'. self::TOC_TEMPLATE
        ];

        $components = $this->getComponents($paths['source']);
        $tocTemplate = json_decode(file_get_contents($paths['tocTemplate']), true);

        foreach ($components as $component) {
            $output->writeln(sprintf('Writing documentation for %s', $component['id']));
            $output->writeln('--------------');

            $input = $paths['project'] . $component['path'];
            $version = $this->getComponentVersion($paths['manifest'], $component['id']);

            $outputPath = ($release)
                ? $paths['output'] .'/'. $component['id'] .'/'. $version
                : $paths['output'] .'/'. $component['id'] .'/master';

            $output->writeln(sprintf('Writing to %s', $outputPath));

            $types = new TypeGenerator($outputPath);
            $source = $this->getFilesList($input);

            $docs = new DocGenerator($types, $source, $outputPath, $this->cliBasePath);
            $docs->generate($component['path']);

            $types->write();

            $output->writeln(sprintf('Writing table of contents to %s', $outputPath));
            $services = json_decode(file_get_contents($paths['toc'] .'/'. $component['id'] .'.json'), true);
            $toc = new TableOfContents($tocTemplate, $services, $version, $outputPath);
            $toc->generate();

            $output->writeln(' ');
            $output->writeln(' ');
        }

        $output->writeln('Writing ServiceBuilder documentation');
        $output->writeln('--------------');

        $version = $this->getComponentVersion($paths['manifest'], 'google-cloud');
        $outputPath = ($release)
                ? $paths['output'] .'/'. 'google-cloud/'. $version
                : $paths['output'] .'/'. 'google-cloud/master';

        $output->writeln(sprintf('Writing to %s', $outputPath));

        $types = new TypeGenerator($paths['output'] .'/google-cloud');
        $files = [$paths['project'] .'src/ServiceBuilder.php'];

        $docs = new DocGenerator($types, $files, $outputPath, $this->cliBasePath);
        $docs->generate('src/');

        $types->write();

        $output->writeln(sprintf('Writing table of contents to %s', $outputPath));
        $services = json_decode(file_get_contents($paths['toc'] .'/google-cloud.json'), true);
        $toc = new TableOfContents($tocTemplate, $services, $version, $outputPath);
        $toc->generate();
    }

    private function getFilesList($source)
    {
        $directoryIterator = new RecursiveDirectoryIterator($source);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $regexIterator = new RegexIterator($iterator, '/^.+\.php|^.+\.md$/i', RecursiveRegexIterator::GET_MATCH);
        $files = [];

        foreach ($regexIterator as $item) {
            array_push($files, $item[0]);
        }

        return $files;
    }
}
