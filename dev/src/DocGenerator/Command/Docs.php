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
use Google\Cloud\Dev\DocGenerator\FileListFilterIterator;
use Google\Cloud\Dev\DocGenerator\GuideGenerator;
use Google\Cloud\Dev\DocGenerator\RegexFileFilter;
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
    const DEFAULT_SOURCE_DIR = '';

    private $cliBasePath;

    private $testPaths = [
        'tests/Unit',
        'tests/Snippet',
        'tests/System',
        'tests/Conformance',
    ];

    public function __construct($cliBasePath)
    {
        $this->cliBasePath = realpath($cliBasePath);

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('docs')
            ->setDescription('Generate Documentation')
            ->addOption('release', 'r', InputOption::VALUE_NONE, 'If set, docs will be generated into tag folders' .
                ' such as v1.0.0 rather than master.')
            ->addOption('pretty', 'p', InputOption::VALUE_NONE, 'If set, json files will be written with pretty'.
                ' formatting using PHP\'s JSON_PRETTY_PRINT flag');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $release = $input->getOption('release');
        $pretty = $input->getOption('pretty');

        $paths = [
            'source' => $this->cliBasePath .'/../'. self::DEFAULT_SOURCE_DIR,
            'output' => $this->cliBasePath .'/../'. self::DEFAULT_OUTPUT_DIR,
            'project' => $this->cliBasePath .'/../',
            'manifest' => $this->cliBasePath .'/../docs/manifest.json',
            'toc' => $this->cliBasePath .'/../'. self::TOC_SOURCE_DIR,
            'tocTemplate' => $this->cliBasePath .'/../'. self::TOC_TEMPLATE,
            'overview' => $this->cliBasePath .'/../'. self::OVERVIEW_FILE
        ];

        $components = $this->getComponents(dirname($this->cliBasePath), $paths['source']);
        $tocTemplate = json_decode(file_get_contents($paths['tocTemplate']), true);

        foreach ($components as $component) {
            $input = $paths['project'] . $component['path'] .'/src';
            $source = $this->getFilesList($input, ['php', 'md'], [
                'CONTRIBUTING.md'
            ]);
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

        $projectRealPath = realpath($paths['project']);
        $source = $this->getFilesList($projectRealPath, [
            'php', 'md'
        ], [
            $projectRealPath .'/vendor',
            $projectRealPath .'/dev',
            $projectRealPath .'/build',
            $projectRealPath .'/docs',
            $projectRealPath .'/tests',
            '.github',
            new RegexFileFilter(str_replace('/', '\/', preg_quote($projectRealPath .'/') . '\w{0,}\.\w{0,}')),
            'bootstrap.php'
        ]);

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

    /**
     * @param string $source The base directory to iterate.
     * @param string[] $types A list of file extensions to include. Do not
     *        include the leading dot.
     * @param string[] $excludes A list of directories or patterns to exclude.
     *        If the string begins with a forward-slash it will be treated as an
     *        absolute file path. Otherwise, the given string will be checked
     *        for existence in the absolute file path and excluded if it is
     *        found. (in other words, `strpos($exclude, $path) !== false`.)
     * @return string[] A list of absolute paths to included files.
     */
    private function getFilesList($source, array $types, array $excludes = [])
    {
        $directoryIterator = new RecursiveDirectoryIterator($source);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        // $regexIterator = new RegexIterator($iterator, $regex, RecursiveRegexIterator::GET_MATCH);
        $fileList = new FileListFilterIterator($iterator, $types, $this->testPaths, $excludes);
        $files = [];

        foreach ($fileList as $item) {
            array_push($files, realPath($item->getPathName()));
        }

        return $files;
    }
}
