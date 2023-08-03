<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\V2;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\EmulatorTrait;
use Google\ApiCore\Veneer\RequestWrapper;
use Google\Cloud\Core\V2\RequestCallerTrait;

class RequestHandler
{
    use EmulatorTrait;
    use RequestCallerTrait;

    /**
     * @var array
     */
    private $clientConfig;

    /**
     * @var array
     */
    private $gapics;

    private $serializer;

    /**
     * @param array $config
     */
    public function __construct(
        Serializer $serializer,
        array $gapicClasses = [],
        array $config = []
    ) {
        //@codeCoverageIgnoreStart

        $config['serializer'] = $serializer;
        $this->serializer = $serializer;
        $config += ['emulatorHost' => null];
        // TODO: We should be able to swap out the use of
        // GrpcRequestWrapper with either something in gax, or
        // have the functionality in this file itself.
        $this->setRequestWrapper(new RequestWrapper($config));
        $grpcConfig = $this->getGaxConfig(
            $this->pluck('libVersion', $config),
            isset($config['authHttpHandler'])
                ? $config['authHttpHandler']
                : null,
            $config['transport'] ?? $this->getDefaultTransport()
        );

        if (isset($config['apiEndpoint'])) {
            $grpcConfig['apiEndpoint'] = $config['apiEndpoint'];
        }

        if ((bool) $config['emulatorHost']) {
            $grpcConfig = array_merge(
                $grpcConfig,
                $this->emulatorGapicConfig($config['emulatorHost'])
            );
        }
        //@codeCoverageIgnoreEnd

        $this->clientConfig = $grpcConfig;

        // initialize the gapics
        foreach($gapicClasses as $gapicClass) {
            $this->gapics[$gapicClass] = new $gapicClass($this->clientConfig);
        }
    }

    /**
     * Helper function that forwards the request to a gapic client obj.
     * 
     * @param $gapicClass The object of this GAPIC client will be used.
     * @param $method This method needs to be called on the gapic obj.
     * @param $requiredArgs The positional arguments to be passed on the $method
     * @param $args The optional args.
     * 
     * TODO: Probably we can have the $gapicClass as the last param which is null
     * only in cases where the resource only interacts with only one GAPIC
     * and therefore, only one GAPIC was passed in the constructor
     */
    public function sendReq(
        $gapicClass,
        string $method,
        array $requiredArgs,
        array $optionalArgs,
        bool $whitelisted = false) {

        $allArgs = $requiredArgs;

        // we send the optional args in the end, because everything before that is
        // passed on the the `$method` as a positional argument
        // TODO: If we merge the GrpcRequestWrapper funcationality here,
        // we can modify this behaviour
        $allArgs[] = $optionalArgs;

        // fetch the gapic obj to use while sending the req.
        $obj = $this->gapics[$gapicClass];

        // TODO: check how can we simplify the use of $whitelisted
        return $this->send([$obj, $method], $allArgs, $whitelisted);
    }

    private function getDefaultTransport()
    {
        $isGrpcExtensionLoaded = $this->isGrpcLoaded();
        $defaultTransport = $isGrpcExtensionLoaded ? 'grpc' : 'rest';
        return $defaultTransport;
    }

    protected function isGrpcLoaded()
    {
        return extension_loaded('grpc');
    }
}
