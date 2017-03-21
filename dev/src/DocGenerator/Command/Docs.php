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
    const OVERVIEW_FILE = 'docs/overview.html';
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
                ' such as v1.0.0 rather than master.', false)
            ->addOption('pretty', 'p', InputOption::VALUE_OPTIONAL, 'If set, json files will be written with pretty'.
                ' formatting using PHP\'s JSON_PRETTY_PRINT flag', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $release = ($input->getOption('release') === false && $input->getOption('release') !== 'false')
            ? null
            : $input->getOption('release');

        $pretty = ($input->getOption('pretty') === false) ? false : true;

        $paths = [
            'source' => $this->cliBasePath .'/../'. self::DEFAULT_SOURCE_DIR,
            'output' => $this->cliBasePath .'/../'. self::DEFAULT_OUTPUT_DIR,
            'project' => $this->cliBasePath .'/../',
            'manifest' => $this->cliBasePath .'/../docs/manifest.json',
            'toc' => $this->cliBasePath .'/../'. self::TOC_SOURCE_DIR,
            'tocTemplate' => $this->cliBasePath .'/../'. self::TOC_TEMPLATE,
            'overview' => $this->cliBasePath .'/../'. self::OVERVIEW_FILE
        ];

        $components = $this->getComponents($paths['source']);
        $tocTemplate = json_decode(file_get_contents($paths['tocTemplate']), true);

        foreach ($components as $component) {
            $input = $paths['project'] . $component['path'];
            $source = $this->getFilesList($input);
            $this->generateComponentDocumentation(
                $output,
                $source,
                $component,
                $paths,
                $tocTemplate,
                $release,
                $pretty
            );
        }

        $source = $this->getFilesList($paths['project'] . '/src');
        $component = [
            'id' => 'google-cloud',
            'path' => 'src/'
        ];

        $this->generateComponentDocumentation(
            $output,
            $source,
            $component,
            $paths,
            $tocTemplate,
            $release,
            $pretty,
            false
        );
    }

    private function generateComponentDocumentation(
        OutputInterface $output,
        array $source,
        array $component,
        array $paths,
        $tocTemplate,
        $release = false,
        $pretty = false,
        $isComponent = true
    ) {
        $output->writeln(sprintf('Writing documentation for %s', $component['id']));
        $output->writeln('--------------');

        $version = $this->getComponentVersion($paths['manifest'], $component['id']);

        $outputPath = ($release)
            ? $paths['output'] .'/'. $component['id'] .'/'. $version
            : $paths['output'] .'/'. $component['id'] .'/master';

        $output->writeln(sprintf('Writing to %s', realpath($outputPath)));

        $types = new TypeGenerator($outputPath);

        $docs = new DocGenerator(
            $types,
            $source,
            $outputPath,
            $this->cliBasePath,
            $component['id'],
            $paths['manifest'],
            $release,
            $isComponent
        );

        $docs->generate($component['path'], $pretty);

        $types->write($pretty);

        $output->writeln(sprintf('Writing table of contents to %s', realpath($outputPath)));
        $contents = json_decode(file_get_contents($paths['toc'] .'/'. $component['id'] .'.json'), true);

        $toc = new TableOfContents(
            $tocTemplate,
            $component['id'],
            $this->getComponentVersion($paths['manifest'], 'google-cloud'),
            $paths['toc'],
            $outputPath,
            $release
        );
        $toc->generate($pretty);

        $output->writeln(sprintf('Copying overview.html to %s', realpath($outputPath)));
        copy($paths['overview'], $outputPath .'/overview.html');

        $output->writeln(' ');
        $output->writeln(' ');
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
