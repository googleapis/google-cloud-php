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
use Google\Cloud\Dev\AddComponent\Contributing;
use Google\Cloud\Dev\AddComponent\GitAttributes;
use Google\Cloud\Dev\AddComponent\Info;
use Google\Cloud\Dev\AddComponent\License;
use Google\Cloud\Dev\AddComponent\Manifest;
use Google\Cloud\Dev\AddComponent\PullRequestTemplate;
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

        $info = (new Info(
            $this->getHelper('question'),
            $input,
            $output,
            $this->cliBasePath
        ))->run();

        $output->writeln($formatter->formatSection(
            'License',
            'Creating LICENSE file by copying from repository base.'
        ));

        (new License($this->cliBasePath, $info['path']))->run();

        $output->writeln($formatter->formatSection(
            'Pull Request Template',
            'Creating .github/pull_request_template.md file by copying from template.'
        ));

        (new PullRequestTemplate($this->cliBasePath, $info['path']))->run();

        $output->writeln($formatter->formatSection(
            'Contributing Guide',
            'Creating CONTRIBUTING.md file by copying from template.'
        ));

        (new Contributing($this->cliBasePath, $info['path']))->run();

        $output->writeln($formatter->formatSection(
            'Git Attributes',
            'Creating .gitattributes file by copying from template.'
        ));

        (new GitAttributes($this->cliBasePath, $info['path']))->run();

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
            $info['path']
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
