<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Debugger;

use Google\Cloud\DevTools\Source\V1\AliasContext\Kind;

/**
 * An alias to a repo revision.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\AliasContext;
 *
 * $aliasContext = new AliasContext(AliasContext::KIND_FIXED, 'branch-alias');
 * ```
 *
 * @codingStandardsIgnoreStart
 * @see https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee#aliascontext AliasContext model documentation
 * @codingStandardsIgnoreEnd
 */
class AliasContext
{
    const KIND_ANY = Kind::ANY;
    const KIND_FIXED = Kind::FIXED;
    const KIND_MOVABLE = Kind::MOVABLE;
    const KIND_OTHER = Kind::OTHER;

    /**
     * @var string The alias kind.
     */
    public $kind;

    /**
     * @var string The alias name.
     */
    public $name;

    /**
     * Instantiate a new AliasContext.
     *
     * @param string $kind The alias kind.
     * @param string $name The alias name.
     */
    public function __construct($kind, $name)
    {
        $this->kind = $kind;
        $this->name = $name;
    }

    /**
     * Return a serializable version of this object
     *
     * @access private
     * @return array
     */
    public function info()
    {
        return [
            'kind' => $this->kind,
            'name' => $this->name
        ];
    }
}
