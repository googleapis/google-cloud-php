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

use Google\Cloud\Dev\QuestionTrait;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Configure the docs manifest
 */
class Manifest
{
    use PathTrait;
    use QuestionTrait;

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

    /**
     * @var array
     */
    private $info;

    /**
     * @var array
     */
    private $defaultDeps = [
        'ext-grpc',
        'google/gax'
    ];

    public function __construct(
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output,
        $rootPath,
        array $info
    ) {
        $this->questionHelper = $questionHelper;
        $this->input = $input;
        $this->output = $output;
        $this->rootPath = $rootPath;
        $this->path = $info['path'];
        $this->info = $info;
    }

    public function run()
    {
        $path = $this->rootPath .'/docs/manifest.json';
        $manifest = json_decode(file_get_contents($path), true);

        $modules = $manifest['modules'];
        $matches = array_filter($modules, function ($module) {
            return $module['id'] === $this->info['name'];
        });

        if ($matches) {
            $continue = $this->ask(sprintf(
                'The component %s alreay exists in the manifest. Continuing will overwrite. Enter "continue" to continue.',
                $this->info['name']
            ));

            if (strtolower($continue) !== 'continue') {
                $this->output->writeln('skipping further work in docs manifest.');
                return;
            } else {
                unset($modules[array_keys($matches)[0]]);
            }
        }
        $q = $this->question(
            'Enter the default service. For handwritten clients, this will be the client entry point. ' .
            'For instance, if the service is `Foo/FooClient.php`, enter `FooClient.php`. ' .
            'For Gapic-only clients, the default service is generally the README file.',
            'README.md'
        )->setValidator(function ($answer) {
            if (!file_exists($this->path .'/'. $answer)) {
                throw new \RuntimeException('file does not exist');
            }

            $pathParts = explode('/', $this->path);
            $last = array_pop($pathParts);

            $answerParts = explode('.', $answer);
            array_pop($answerParts);
            return strtolower($last .'/'. implode('.', $answerParts));
        });

        $defaultService = $this->askQuestion($q);

        $manifestEntry = [
            'id' => $this->info['name'],
            'name' => 'google/'. $this->info['name'],
            'defaultService' => $defaultService,
            'versions' => ['master']
        ];

        $modules[] = $manifestEntry;

        $main = $modules[0];
        unset($modules[0]);

        usort($modules, function ($item1, $item2) {
            return strcmp($item1['id'], $item2['id']);
        });

        array_unshift($modules, $main);

        $manifest['modules'] = $modules;

        file_put_contents($path, json_encode($manifest, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL);
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
