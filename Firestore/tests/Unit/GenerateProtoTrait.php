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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\ApiCore\Serializer;
use Google\Protobuf\Internal\Message;
use InvalidArgumentException;

trait GenerateProtoTrait
{
    private static function generateProto(string $message, array $data): Message
    {
        /** @var Message */
        $message = new $message();

        $serializer = new Serializer();
        return $serializer->decodeMessage($message, $data);
    }
}
