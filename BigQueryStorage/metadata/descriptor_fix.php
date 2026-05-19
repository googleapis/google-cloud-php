<?php
/*
 * Copyright 2023 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * IMPORTANT: This file is to prevent the following error from being thrown in this library when
 * the native PHP protobuf library is used:
 *
 *   "proto not added: google.protobuf.DescriptorProto for google.cloud.bigquery.storage.v1.ProtoSchema"
 *
 * This file can be removed once a fix is implemented in the protobuf library
 * @see https://github.com/protocolbuffers/protobuf/issues/11649
 */
namespace GPBMetadata\Google\Protobuf {

    class DescriptorFix
    {
        public static $is_initialized = false;

        public static function initOnce() {
            $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

            if (static::$is_initialized == true) {
            return;
            }

            if ($pool instanceof \Google\Protobuf\Internal\DescriptorPool) {
                // add a no-op reference for "google.protobuf.DescriptorProto"
                $pool->addMessage('google.protobuf.DescriptorProto', \Google\Protobuf\DescriptorProto::class)->finalizeToPool();
            }
            static::$is_initialized = true;
        }
    }

    DescriptorFix::initOnce();
}

namespace Google\Protobuf {

    class DescriptorProto
    {
        public function __construct()
        {
            throw new \LogicException('Proto2 classes are not supported');
        }
    }
}

