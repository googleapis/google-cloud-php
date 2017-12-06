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

namespace Google\Cloud\Dev\AddComponent\Command;

use Google\Cloud\Dev\AddComponent\Composer;
use Google\Cloud\Dev\AddComponent\License;
use Google\Cloud\Dev\AddComponent\Manifest;
use Google\Cloud\Dev\AddComponent\QuestionTrait;
use Google\Cloud\Dev\AddComponent\Readmes;
use Google\Cloud\Dev\AddComponent\TableOfContents;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Add a Component
 */
class AddComponent extends Command
{
    use QuestionTrait;

    private $cliBasePath;
    private $templatesPath;

    private $input;
    private $output;

    public function __construct($cliBasePath)
    {
        $this->cliBasePath = $cliBasePath;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('component')
            ->setDescription('Add a Component');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // this is gross.
        $this->input = $input;
        $this->output = $output;

        $formatter = $this->getHelper('formatter');

        $info = [];
        $info['name'] = $this->ask(
            'Please enter the component name, omitting the vendor ' .
            '(e.g. cloud-foo)'
        );

        $info['display'] = $this->ask(
            'Please enter the component display name ' .
            '(e.g. Google Cloud Foo)'
        );

        $q = $this->question(
            'Please enter the URI of the service homepage on cloud.google.com'
        )->setValidator(function ($answer) {
            if (strpos($answer, '://') === false) {
                $answer = 'https://'. $answer;
            }

            return $answer;
        });

        $info['cloudPage'] = $this->askQuestion($q);

        $q = $this->question(
            'Please enter the URI of the documentation homepage on cloud.google.com',
            $info['cloudPage'] .'/docs'
        )->setValidator(function ($answer) {
            if (strpos($answer, '://') === false) {
                $answer = 'https://'. $answer;
            }

            return $answer;
        });

        $info['docsPage'] = $this->askQuestion($q);

        $base = $this->cliBasePath . '/../src/';
        $q = $this->question(
            'Please enter the directory name, relative to `src/`, where the component is found. ' .
            'For instance, if the directory is `src/Foo`, enter `Foo`.'
        )->setValidator(function ($answer) use ($base) {
            $path = $base . $answer;

            if (!is_dir($path)) {
                throw new \RuntimeException(
                    $path .' does not exist or is not a folder.'
                );
            }

            return $path;
        })->setMaxAttempts(null);

        $path = $this->askQuestion($q);

        $output->writeln($formatter->formatSection(
            'License',
            'Creating LICENSE file by copying from repository base.'
        ));

        (new License($this->cliBasePath, $path))->run();

        $output->writeln($formatter->formatSection(
            'Readme',
            'Every directory which contains documented classes should contain a README file. ' .
            'README files are populated using information you already supplied. ' .
            'When a directory does not contain a single entry point, or a main client class, ' .
            'README functions as a main service. In certain cases, README files are not ' .
            'desirable. In clients with GAPICs, the `Gapic` and `resources` folders generally should not ' .
            'include READMEs, because the Gapic client is documented in the parent class.' .
            PHP_EOL
        ));

        $readme = new Readmes(
            $this->getHelper('question'),
            $input,
            $output,
            $this->cliBasePath,
            $path,
            $info
        );
        $readme->run();

        $output->writeln($formatter->formatSection(
            'Table of Contents',
            'The main service for a directory is what users will see when they first ' .
            'encounter an endpoint in the documentation hierarchy. If a main service ' .
            'is present (as in handwritten clients), that service should be used. ' .
            'If not, choose README.md' .
            PHP_EOL
        ));

        (new TableOfContents(
            $this->getHelper('formatter'),
            $this->getHelper('question'),
            $input,
            $output,
            $this->cliBasePath,
            $path
        ))->run($info['name']);

        $output->writeln($formatter->formatSection(
            'Table of Contents',
            'Wrote table of contents data.' . PHP_EOL
        ));

        $output->writeln($formatter->formatSection(
            'Composer',
            'The following questions allow us to properly configure the new component ' .
            'for use with PHP\'s package manager, Composer.'
        ));

        (new Composer(
            $this->getHelper('question'),
            $input,
            $output,
            $this->cliBasePath,
            $path,
            $info
        ))->run();

        $output->writeln($formatter->formatSection(
            'Docs Manifest',
            'Finally, we need to configure the manifest for the documentation site.'
        ));

        (new Manifest(
            $this->getHelper('question'),
            $input,
            $output,
            $this->cliBasePath,
            $path,
            $info
        ))->run();

        $output->writeln('');
        $output->writeln('');
        $output->writeln('Success!');
    }

    protected function questionHelper()
    {
        return $this->getHelper('question');
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
