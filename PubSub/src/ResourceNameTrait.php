<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\PubSub;

use InvalidArgumentException;

/**
 * Trait which provides helpers around PubSub resource names.
 */
trait ResourceNameTrait
{
    /**
     * @var array
     */
    private $templates = [
        'project' => 'projects/%1$s',
        'topic' => 'projects/%2$s/topics/%1$s',
        'subscription' => 'projects/%2$s/subscriptions/%1$s',
        'snapshot' => 'projects/%2$s/snapshots/%1$s'
    ];

    /**
     * @var array
     */
    private $regexes = [
        'project' => '/^projects\/([^\/]*)$/',
        'topic' => '/projects\/[^\/]*\/topics\/(.*)/',
        'subscription' => '/projects\/[^\/]*\/subscriptions\/(.*)/',
        'snapshot' => '/projects\/[^\/]*\/snapshots\/(.*)/'
    ];

    /**
     * Convert a fully-qualified name into a simple name.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('projects/my-awesome-project/topics/my-topic-name');
     * echo $topic->pluckName('topic', $name); // `my-topic-name`
     * ```
     *
     * @param  string $name
     * @return string
     * @throws \InvalidArgumentException
     */
    private function pluckName($type, $name)
    {
        if (!isset($this->regexes[$type])) {
            throw new InvalidArgumentException(sprintf(
                'Regex `%s` is not defined',
                $type
            ));
        }

        $matches = [];
        $res = preg_match($this->regexes[$type], $name, $matches);
        return ($res === 1) ? $matches[1] : null;
    }

    /**
     * Convert a simple name into the fully-qualified name required by
     * the API.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     * echo $topic->formatName('topic', $name); // `projects/my-awesome-project/topics/my-topic-name`
     * ```
     *
     * @param  string $type
     * @param  string $name
     * @param  string $projectId [optional]
     * @return string
     * @throws \InvalidArgumentException
     */
    private function formatName($type, $name, $projectId = null)
    {
        if (!isset($this->templates[$type])) {
            throw new InvalidArgumentException(sprintf(
                'Template `%s` is not defined',
                $type
            ));
        }

        return vsprintf($this->templates[$type], [$name, $projectId]);
    }

    /**
     * Check if a name of a give type is a fully-qualified resource name.
     *
     * Example:
     * ```
     * $topic = $pubsub->topic('my-topic-name');
     * if ($topic->isFullyQualifiedName('project', 'projects/my-awesome-project/topics/my-topic-name')) {
     *     // do stuff
     * }
     * ```
     *
     * @param  string $type
     * @param  string $name
     * @return bool
     * @throws \InvalidArgumentException
     */
    private function isFullyQualifiedName($type, $name)
    {
        if (!isset($this->regexes[$type])) {
            throw new InvalidArgumentException(sprintf(
                'Regex `%s` is not defined',
                $type
            ));
        }
        $name = empty($name) ? '' : $name;
        return (preg_match($this->regexes[$type], $name) === 1);
    }
}
