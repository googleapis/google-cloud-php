<?php
/*
 * Copyright 2018 Google LLC
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

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/redis/v1/cloud_redis.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Redis\V1;

use Google\Cloud\Redis\V1\Gapic\CloudRedisGapicClient;

/**
 * {@inheritdoc}
 */
class CloudRedisClient extends CloudRedisGapicClient
{
    protected function modifyClientOptions(array &$options)
    {
        if (isset($options['transport'])) {
            if ($options['transport'] == 'rest') {
                throw new \InvalidArgumentException(
                    'The "rest" transport is not currently supported, ' .
                    'please use the "grpc" transport.'
                );
            }
            // If transport is set to anything other than rest, take no action
            // and process as usual in setClientOptions
        } else {
            // If transport is not set, default to grpc.
            $options['transport'] = 'grpc';
        }
    }
}
