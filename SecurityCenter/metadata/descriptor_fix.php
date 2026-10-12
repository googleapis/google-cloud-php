<?php
/*
 * Copyright 2026 Google LLC
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
 * IMPORTANT: This file prevents an exception when `PBObject` is used.
 * The `Object` class from `google/cloud/securitycenter/v1/kubernetes.proto` was manually
 * renamed to `PBObject` in PHP to avoid a conflict with a PHP reserved keyword.
 * This file ensures that the `PBObject` class is correctly registered with the
 * Protobuf descriptor pool under its original `Object` descriptor.
 *
 * This file can be removed once the protobuf library introduces a fix for
 * descriptor pool issues when classes are renamed due to reserved keywords.
 * @see https://github.com/protocolbuffers/protobuf/pull/27456
 */
namespace GPBMetadata\Google\Cloud\Securitycenter\V1 {

    class DescriptorFix
    {
        public static $is_initialized = false;

        public static function initOnce() {
            if (static::$is_initialized == true) {
                return;
            }

            $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
            if ($pool instanceof \Google\Protobuf\Internal\DescriptorPool) {
                $pool->addMessage(
                    'google.cloud.securitycenter.v1.Kubernetes.Object',
                    \Google\Cloud\SecurityCenter\V1\Kubernetes\PBObject::class
                )->finalizeToPool();
            }

            static::$is_initialized = true;
        }
    }

    DescriptorFix::initOnce();
}

