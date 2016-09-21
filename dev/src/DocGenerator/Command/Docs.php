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
use Google\Cloud\Dev\DocGenerator\TypeGenerator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Docs extends Command
{
    const DEFAULT_OUTPUT_DIR = 'docs/json/master';
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
            ->addArgument('source', InputArgument::OPTIONAL, 'The source directory to traverse and parse')
            ->addArgument('output', InputArgument::OPTIONAL, 'The directory to output files into');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $paths = [
            'source' => ($input->getArgument('source'))
                ? $this->cliBasePath .'/../'. $input->getArgument('source')
                : $this->cliBasePath .'/../'. self::DEFAULT_SOURCE_DIR,

            'output' => ($input->getArgument('output'))
                ? $this->cliBasePath .'/../'. $input->getArgument('output')
                : $this->cliBasePath .'/../'. self::DEFAULT_OUTPUT_DIR
        ];

        $types = new TypeGenerator($paths['output']);

        $sourceFiles = $this->getFilesList($paths['source']);
        $docs = new DocGenerator($types, $sourceFiles, $paths['output'], $this->cliBasePath);
        $docs->generate();

        $types->write();
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
