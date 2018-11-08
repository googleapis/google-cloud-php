<?php
/**
 * Copyright 2018 Google LLC.
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

namespace Google\Cloud\Core\Report;

/**
 * An MetadataProvider for GAE Standard.
 */
class GAEStandardMetadataProvider extends GAEMetadataProvider
{
    protected function getTraceValue($server)
    {
        $traceId = substr($server['HTTP_X_CLOUD_TRACE_CONTEXT'], 0, 32);
        if (isset($server['GOOGLE_CLOUD_PROJECT'])) {
            return sprintf(
                'projects/%s/traces/%s',
                $server['GOOGLE_CLOUD_PROJECT'],
                $traceId
            );
        }
        return $traceId;
    }
}
