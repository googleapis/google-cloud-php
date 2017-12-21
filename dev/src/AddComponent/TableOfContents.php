<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Dev\AddComponent;

use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generate a Table of Contents
 */
class TableOfContents
{
    const SUGGESTION_TEXT = ' (leave blank to select this option)';
    const TOC_PATH = 'docs/contents';

    use PathTrait;
    use QuestionTrait;

    /**
     * @var OutputFormatterInterface
     */
    private $formatter;

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var string
     */
    private $cliBasePath;

    /**
     * @var string
     */
    private $path;

    public function __construct(
        FormatterHelper $formatter,
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output,
        $cliBasePath,
        $path
    ) {
        $this->formatter = $formatter;
        $this->questionHelper = $questionHelper;
        $this->input = $input;
        $this->output = $output;
        $this->cliBasePath = $cliBasePath;
        $this->path = $path;
    }

    public function run($name)
    {
        $toc = $this->buildToc($this->path, false, true);
        $this->writeToc($name, $toc);

        $this->addToIncludes($name);
    }

    private function directoryHasPhpFile(array $choices)
    {
        $res = false;
        foreach ($choices as $choice) {
            $res = strpos($choice, '.php') !== false;
            if ($res) {
                return $res;
            }
        }

        return $res;
    }

    private function stripDirectories($path, array $files)
    {
        foreach ($files as $i => $file) {
            if (is_dir($path .'/'. $file)) {
                unset($files[$i]);
            }
        }

        return array_values($files);
    }

    private function buildToc($path, $main = false, $isTopLevel = false)
    {
        $this->output->writeln($this->formatter->formatSection(
            'Table of Contents',
            sprintf('Working in directory `%s`', realpath($path)) . PHP_EOL
        ));

        $files = $this->scanDirectory($path);

        if (!$main) {
            $skipText = 'skip directory';

            if (strpos($path, 'Gapic') !== false || strpos($path, 'resources') !== false) {
                return;
            }

            $choices = $this->stripDirectories($path, array_values($files));
            $choices[] = $skipText;

            $default = null;
            if ($this->pathIsGapic($path) || !$this->directoryHasPhpFile($choices)) {
                foreach ($choices as $index => &$choice) {
                    if ($choice === 'README.md') {
                        $default = $index;
                        $choice = 'README.md' . self::SUGGESTION_TEXT;
                    }
                }
            }

            $setDefault = function ($answer) use ($default) {
                if (empty($answer) && $answer !== 0 && $answer !== '0' && $default !== null) {
                    return (string) $default;
                }

                return $answer;
            };

            $validator = function ($answer) use ($choices) {
                if (!array_key_exists((int)$answer, $choices)) {
                    throw new \RuntimeException('Invalid selection.');
                }

                $answer = $choices[$answer];
                if ($answer === 'README.md' . self::SUGGESTION_TEXT) {
                    $answer = 'README.md';
                }

                return $answer;
            };

            $q = $this->choice('Please select the main service.', $choices)
                ->setValidator($this->validators([
                    $setDefault,
                    $this->preventEmpty(),
                    $validator,
                ]));

            $main = $this->askQuestion($q);
            if ($main === $skipText) {
                return;
            }

            $i = array_search($main, $files);
            unset($files[$i]);
        }

        $services = [];
        $main = $this->buildSingleTocEntry(new \SplFileInfo($main), $path, true);

        if ($isTopLevel) {
            $services[] = [
                'title' => 'Overview',
                'type' => $main['type']
            ];

            unset($main['type']);
        }

        $i = array_search('README.md', $files);
        unset($files[$i]);

        $i = array_search($main, $files);
        unset($files[$i]);

        foreach ($files as $file) {
            $service = $this->buildSingleTocEntry(new \SplFileInfo($file), $path);
            if (!empty($service)) {
                $services[] = $service;
            }
        }

        if ($isTopLevel) {
            $parent = explode('/', $services[0]['type']);
        } else {
            $parent = explode('/', $main['type']);
        }

        array_pop($parent);
        $parent = implode('/', $parent);

        if ($isTopLevel) {
            $main['services'] = $services;
        } else {
            $main['nav'] = $services;
        }

        $pattern = $parent .'/\w{1,}';
        if ($isTopLevel) {
            $main['pattern'] = $pattern;
        } else {
            $main['patterns'] = [$pattern];
        }

        return $main;
    }

    private function buildSingleTocEntry(\SplFileInfo $file, $path, $isMain = false)
    {
        if (is_dir($path .'/'. $file)) {
            return $this->buildToc($path .'/'. $file);
        }

        $file = new \SplFileInfo($file);
        if (!in_array($file->getExtension(), ['php', 'md'])) {
            return;
        }

        $file = trim($file, '/');

        if (!$isMain) {
            $q = $this->confirm(sprintf('Should %s be included in the table of contents?', $file));
            $include = $this->askQuestion($q);
            if (!$include) {
                return;
            }
        }

        $withoutExt = explode('.', $file)[0];
        $base = trim(explode('src', realpath($path))[1], '/');

        if (strpos($file, 'README.md') !== false) {
            $parts = explode('/', $path);
            $last = array_pop($parts);

            if ($this->pathIsGapic($path)) {
                $last = strtolower($last);
            }
            $suggestedTitle = $last;
        } else {
            $suggestedTitle = basename($withoutExt);
        }

        $title = $this->ask('Enter the service title', $suggestedTitle);

        return [
            'title' => $title,
            'type' => strtolower($base .'/'. $withoutExt)
        ];
    }

    private function writeToc($name, array $toc)
    {
        $path = $this->cliBasePath .'/../'. self::TOC_PATH .'/'. $name .'.json';
        file_put_contents($path, json_encode($toc, JSON_PRETTY_PRINT) . PHP_EOL);
    }

    private function addToIncludes($name)
    {
        $path = $this->cliBasePath .'/../'. self::TOC_PATH .'/google-cloud.json';
        $toc = json_decode(file_get_contents($path), true);
        $toc['includes'][] = $name;
        sort($toc['includes']);
        $toc['includes'] = array_unique($toc['includes']);

        $this->writeToc('google-cloud', $toc);
    }

    protected function questionHelper()
    {
        return $this->questionHelper;
    }

    protected function input()
    {
        return $this->input;
    }

    protected function output()
    {
        return $this->output;
    }
}
