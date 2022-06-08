<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core;

/**
 * Provides common logic for configuring the usage of an emulator.
 */
trait EmulatorTrait
{
    /**
     * Configure the gapic configuration to use a service emulator.
     *
     * @param string $emulatorHost
     * @return array
     */
    private function emulatorGapicConfig($emulatorHost)
    {
        // Strip the URL scheme from the input, if it was provided.
        if ($scheme = parse_url($emulatorHost, PHP_URL_SCHEME)) {
            $search = $scheme . '://';
            $emulatorHost = str_replace($search, '', $emulatorHost);
        }

        return [
            'apiEndpoint' => $emulatorHost,
            'transportConfig' => [
                'grpc' => [
                    'stubOpts' => [
                        'credentials' => \Grpc\ChannelCredentials::createInsecure()
                    ]
                ]
            ],
            'credentials' => new InsecureCredentialsWrapper(),
        ];
    }
    /**
     * Retrieve a valid base uri for a service emulator.
     *
     * @param string $emulatorHost
     * @return string
     */
    private function emulatorBaseUri($emulatorHost)
    {
        $emulatorUriComponents = parse_url($emulatorHost);
        $emulatorUriComponents = array_merge(['scheme' => 'http', 'port' => ''], $emulatorUriComponents);
        $baseUri = "{$emulatorUriComponents['scheme']}://{$emulatorUriComponents['host']}";
        $baseUri .= $emulatorUriComponents['port'] ? ":{$emulatorUriComponents['port']}/" : '/';

        return $baseUri;
    }

    /**
     * When emulators are enabled, use them as the service host.
     *
     * This method is deprecated and will be removed in a future major release.
     *
     * @param string $baseUri
     * @param string $emulatorHost [optional]
     * @return string
     *
     * @deprecated
     * @access private
     */
    public function getEmulatorBaseUri($baseUri, $emulatorHost = null)
    {
        if ($emulatorHost) {
            $baseUri = $this->emulatorBaseUri($emulatorHost);
        }

        return $baseUri;
    }
}
