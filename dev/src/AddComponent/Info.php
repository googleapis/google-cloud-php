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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Collect basic component information
 */
class Info
{
    use ComponentTypeTrait;
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

    public function __construct(
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output,
        $rootPath
    ) {
        $this->questionHelper = $questionHelper;
        $this->input = $input;
        $this->output = $output;
        $this->rootPath = $rootPath;
    }

    public function run()
    {
        $info = [];

        $info['shortName'] = $this->askShortName();

        $info['name'] = $this->askComponentName($info);

        $info['display'] = $this->askDisplayName($info);

        $info['cloudPage'] = $this->askCloudPage(
            'Please enter the URI of the service homepage',
            sprintf('https://cloud.google.com/%s', $info['shortName']),
            $info
        );

        $default = $info['cloudPage'] . '/docs';
        $default = explode('://', $default);
        $default[1] = str_replace('//', '/', $default[1]);

        $info['docsPage'] = $this->askCloudPage(
            'Please enter the URI of the documentation homepage',
             $default[0] . '://' . $default[1],
            $info
        );

        $default = str_replace(' ', '', ucwords(str_replace('-', ' ', $info['shortName'])));
        $base = $this->rootPath;
        $q = $this->question(
            'Please enter the directory name, relative to the google-cloud-php root, where the component is found. Be sure to verify correct casing.',
            $default
        )->setValidator(function ($answer) use ($base) {
            $path = realpath($relativePath);

            if (!is_dir($path)) {
                throw new \RuntimeException(
                    $path .' does not exist or is not a folder.'
                );
            }

            return $path;
        });

        $info['path'] = $this->askQuestion($q);

        $defaultType = $this->getComponentTypeValue('gapic');
        $q = $this->choice(
            'What type of component is this?',
            $this->getComponentTypesListValues(),
            $defaultType
        )->setValidator($this->validators([
            $this->defaultChoice($defaultType),
            $this->preventEmpty(),
            $this->removeDefaultNotice($defaultType),
            function ($answer) {
                return $this->getComponentTypeKey($answer);
            }
        ]));
        $info['type'] = $this->askQuestion($q);

        $this->output->writeln('Confirm entered data');
        foreach ($info as $key => $val) {
            $this->output->writeln(sprintf('<info>%s</info>: %s', $key, $val));
        }

        if (!$this->askQuestion($this->confirm('Does everything look correct? Choosing no will restart the wizard.'))) {
            return $this->run();
        }

        return $info;
    }

    private function askCloudPage($description, $default, array $info)
    {
        $default = $this->validUri($default)
            ? $default
            : null;

        if (!$default) {
            $description = $description . ' (could not determine a valid default)';
        }
        $q = $this->question(
            $description,
            $default
        )->setValidator($this->validators([
            $this->preventEmpty(),
            function ($answer) use ($default) {
                if ($answer === $default) {
                    return $answer;
                }

                return $this->uriValidate($answer);
            }
        ]));

        return $this->askQuestion($q);
    }

    private function uriValidate($answer)
    {
        if (strpos($answer, '://') === false) {
            $answer = 'https://'. $answer;
        }

        if (strpos($answer, 'http://') !== false) {
            $confirm = $this->confirm('You entered http as the protocol. Should we change this to https?');

            if ($this->askQuestion($confirm)) {
                $answer = str_replace('http://', 'https://', $answer);
            }
        }

        $confirm = $this->confirm('The URI you entered returned a non-200 status code. Would you like to re-enter a different URI?');
        if (!$this->validUri($answer) && $this->askQuestion($confirm)) {
            throw new \RuntimeException('Re-enter a new URI');
        }

        return $answer;
    }

    private function validUri($uri)
    {
        $client = new Client;
        try {
            $res = $client->get($uri);
        } catch (RequestException $e) {
            return false;
        } catch (\Exception $e) {
            return true;
        }

        return true;
    }

    private function askShortName()
    {
        $q = $this->question(
            'Please enter the component short name. Examples include bigquery, datastore, spanner.'
        )->setValidator($this->validators([
            $this->preventEmpty()
        ]));

        return $this->askQuestion($q);
    }

    private function askComponentName(array $info)
    {
        $validator = function ($answer) {
            $answer = trim($answer);

            if (strpos($answer, 'google/') === 0) {
                $answer = str_replace('google/', '', $answer);
            }

            if (strpos($answer, 'cloud-') !== 0) {
                $confirm = $this->confirm(
                    'You entered a non-standard name. Standard name convention is `cloud-<name>`. Accept non-standard name?',
                    false
                );

                if (!$this->askQuestion($confirm)) {
                    throw new \RuntimeException('Re-enter a valid name');
                }
            }

            return $answer;
        };

        $q = $this->question(
            'Please enter the component name, omitting the vendor',
            'cloud-'. $info['shortName']
        )->setValidator($this->validators([
            $this->preventEmpty(),
            $validator
        ]));

        return $this->askQuestion($q);
    }

    private function askDisplayName(array $info)
    {
        $name = 'Google '. ucwords(str_replace('-', ' ', $info['name']));


        return $this->ask(
            'Please enter the component display name',
            $name
        );
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
