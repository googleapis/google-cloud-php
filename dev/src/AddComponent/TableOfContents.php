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
    const SKIP_TEXT = 'skip directory';

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
    private $rootPath;

    /**
     * @var string
     */
    private $path;

    public function __construct(
        FormatterHelper $formatter,
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output,
        $rootPath,
        $path
    ) {
        $this->formatter = $formatter;
        $this->questionHelper = $questionHelper;
        $this->input = $input;
        $this->output = $output;
        $this->rootPath = $rootPath;
        $this->path = $path;
    }

    public function run($name)
    {
        $toc = $this->buildTopLevelToc($this->path);
        $this->writeToc($name, $toc);

        $this->addToIncludes($name);
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

    private function buildToc($path)
    {
        $this->output->writeln($this->formatter->formatSection(
            'Table of Contents',
            sprintf('Working in directory `%s`', realpath($path)) . PHP_EOL
        ));

        $files = $this->scanDirectory($path);

        if (strpos($path, 'Gapic') !== false || strpos($path, 'resources') !== false) {
            return [];
        }

        $choices = $this->stripDirectories($path, array_values($files));

        if (count($choices) === 0) {
            // No choices, so instead skip to iterating over subdirs
            $this->output->writeln($this->formatter->formatSection(
                'Table of Contents',
                sprintf('Eliding directory with no files:`%s`', realpath($path)) . PHP_EOL
            ));
            $tocs = [];
            foreach ($files as $file) {
                if (is_dir($path .'/'. $file)) {
                    $tocs = array_merge($tocs, $this->buildToc($path .'/'. $file));
                }
            }
            return $tocs;
        }

        $q = $this->buildMainServiceQuestion($choices);

        $mainSelection = $this->askQuestion($q);
        if ($mainSelection === self::SKIP_TEXT) {
            return [];
        }

        $entries = $this->buildSingleTocEntry(new \SplFileInfo($mainSelection), $path, true);
        if (count($entries) !== 1) {
            throw new \RuntimeException("Unexpected number of entries for main: $mainSelection");
        }
        $main = $entries[0];

        $services = $this->buildServices($path, $files, [$mainSelection, 'README.md']);

        $parent = $this->calculateParent($main['type']);
        $pattern = $parent .'/\w{1,}';

        $main['nav'] = $services;
        $main['patterns'] = [$pattern];
        return [$main];
    }

    private function buildTopLevelToc($path)
    {
        $this->output->writeln($this->formatter->formatSection(
            'Table of Contents',
            sprintf('Working in directory `%s`', realpath($path)) . PHP_EOL
        ));

        $files = $this->scanDirectory($path);
        $choices = $this->stripDirectories($path, array_values($files));
        $q = $this->buildMainServiceQuestion($choices);
        $mainSelection = $this->askQuestion($q);
        if ($mainSelection === self::SKIP_TEXT) {
            return [];
        }

        $entries = $this->buildSingleTocEntry(new \SplFileInfo($mainSelection), $path, true);
        if (count($entries) !== 1) {
            throw new \RuntimeException("Unexpected number of entries for main: $mainSelection");
        }
        $main = $entries[0];

        $services = [];
        $services[] = [
            'title' => 'Overview',
            'type' => $main['type']
        ];

        $services = array_merge($services, $this->buildServices($path, $files, [$mainSelection, 'README.md']));

        $parent = $this->calculateParent($services[0]['type']);
        $pattern = $parent .'/\w{1,}';

        $main['defaultService'] = $main['type'];
        $main['services'] = $services;
        $main['pattern'] = $pattern;
        unset($main['type']);

        return $main;
    }

    private function buildServices($path, $files, $exclude = [])
    {
        foreach ($exclude as $ex) {
            $i = array_search($ex, $files);
            unset($files[$i]);
        }

        $services = [];
        foreach ($files as $file) {
            $services = array_merge($services, $this->buildSingleTocEntry(new \SplFileInfo($file), $path));
        }
        return $services;
    }

    private function calculateParent($child)
    {
        $parts = explode('/', $child);
        array_pop($parts);
        return implode('/', $parts);
    }

    private function buildMainServiceQuestion($choices)
    {
        $choices[] = self::SKIP_TEXT;

        $default = null;
        foreach ($choices as $index => &$choice) {
            if ($choice === 'README.md') {
                $default = $index;
                $choice = 'README.md' . self::SUGGESTION_TEXT;
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

        return $this->choice('Please select the main service.', $choices)
            ->setValidator($this->validators([
                $setDefault,
                $this->preventEmpty(),
                $validator,
            ]));
    }

    private function buildSingleTocEntry(\SplFileInfo $file, $path, $isMain = false)
    {
        if (is_dir($path .'/'. $file)) {
            return $this->buildToc($path .'/'. $file);
        }

        $file = new \SplFileInfo($file);
        if (!in_array($file->getExtension(), ['php', 'md'])) {
            return [];
        }

        $file = trim($file, '/');

        if (!$isMain) {
            $q = $this->confirm(sprintf('Should %s be included in the table of contents?', $file));
            $include = $this->askQuestion($q);
            if (!$include) {
                return [];
            }
        }

        $withoutExt = explode('.', $file)[0];
        $base = trim(substr($path, strlen($this->rootPath)), '/');

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
        $type = $this->removeSrcDir(strtolower($base .'/'. $withoutExt));

        return [[
            'title' => $title,
            'type' => $type,
        ]];
    }

    private function removeSrcDir($type)
    {
        $parts = explode('/', $type);
        $i = array_search('src', $parts);
        if ($i !== false) {
            unset($parts[$i]);
        }
        return implode('/', $parts);
    }

    private function writeToc($name, array $toc)
    {
        $path = $this->rootPath .'/'. self::TOC_PATH .'/'. $name .'.json';
        file_put_contents($path, json_encode($toc, JSON_PRETTY_PRINT) . PHP_EOL);
    }

    private function addToIncludes($name)
    {
        $path = $this->rootPath .'/'. self::TOC_PATH .'/google-cloud.json';
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
