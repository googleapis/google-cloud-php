<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Spanner;

/**
 * This should not be used directly. It should be accessed via
 * Google\Cloud\Spanner\Database::mutationGroup().
 *
 * @internal
 */
class MutationGroup
{
    use MutationTrait;

    private ValueMapper $mapper;

    /**
     * @param bool $returnInt64AsObject [optional If true, 64 bit integers will
     *        be returned as a {@see \Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility. **Defaults to** false.
     */
    public function __construct($returnInt64AsObject)
    {
        $this->mapper = new ValueMapper($returnInt64AsObject);
    }

    public function toArray(): array
    {
        return ['mutations' => $this->mutationData];
    }
}
