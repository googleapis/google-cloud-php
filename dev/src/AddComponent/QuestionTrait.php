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

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Helpers for asking questions
 */
trait QuestionTrait
{
    protected abstract function questionHelper();
    protected abstract function input();
    protected abstract function output();

    private function ask($question, $default = null)
    {
        $question = $this->question($question, $default);
        return $this->askQuestion($question);
    }

    private function askQuestion(Question $question)
    {
        return $this->questionHelper()->ask(
            $this->input(),
            $this->output(),
            $question
        );
    }

    private function question($question, $default = null)
    {
        if ($default) {
            $question = $question . ' (leave blank for '. $default .')';
        }

        return new Question(
            $question . PHP_EOL,
            $default
        );
    }

    private function choice($question, array $options)
    {
        return new ChoiceQuestion($question, $options);
    }

    private function confirm($question, $defaultToYes = true)
    {
        $choices = implode('/', [
            ($defaultToYes) ? 'y [default]' : 'y',
            (!$defaultToYes) ? 'n [default]' : 'n',
        ]);

        return new ConfirmationQuestion($question . ' (' . $choices .')' . PHP_EOL, $defaultToYes);
    }

    private function validators(array $callables)
    {
        return function ($answer) use ($callables) {
            foreach ($callables as $callable) {
                $answer = call_user_func($callable, $answer);
            }

            return $answer;
        };
    }

    private function preventEmpty($answer)
    {
        if (empty($answer) && $answer !== 0 && $answer !== '0') {
            throw new \RuntimeException('Answer cannot be blank.');
        }

        return $answer;
    }
}
