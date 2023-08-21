<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\PubSub\Tests\Unit;

use Prophecy\Argument;

/**
 * Trait which provides helpers around Argument wildcards and tokens
 * used with prophecy.
 */
trait ArgumentHelperTrait
{

    /**
     * Helper that incorporates some Argument wildcards at specific positions.
     * Any positions not specified in the $tokensArr will be filled by Argument::any().
     * 
     * ```
     * $this->matchesNthArgument([
     *          [Argument::exact('foo'), 2],
     *          [Argument::withKey('bar'), 3]
     * ])
     * ```
     * 
     * The above will result in the following:
     * ```
     * [
     *   Argument::any(),
     *   Argument::exact('foo'),
     *   Argument::withKey('bar'),
     *   Argument::any(),
     * ]
     * ```
     * 
     * The number of tokens is decided by the $totalTokens parameter.
     *
     * @param  array $tokensArr The array containing the wildcard tokens
     * @return int $totalTokens The total number of tokens used in the method call.
     * @return array
     */
    private function matchesNthArgument(array $tokensArr, int $totalTokens = 4)
    {
        $args = [];
        for ($i = 0; $i < $totalTokens; $i++) {
            $args[$i] = Argument::any();
        }

        foreach($tokensArr as $row) {
            $token = $row[0];
            $index = $row[1] - 1;
            $args[$index] = $token;
        }

        return $args;
    }
}
