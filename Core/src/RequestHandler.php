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

namespace Google\Cloud\Core;

use Google\ApiCore\Serializer;

class RequestHandler
{
    use EmulatorTrait;
    use RequestCallerTrait;

    /**
     * @var Serializer
     */
    private $serializer;

    private $gapics;

    /**
     * @param array $config
     */
    public function __construct(
        Serializer $serializer,
        array $gapicClasses,
        array $clientConfig = []
    ) {
        //@codeCoverageIgnoreStart
        $this->serializer = $serializer;
        $clientConfig['serializer'] = $serializer;

        $this->setRequestWrapper(new GapicRequestWrapper($clientConfig));

        // Adds some defaults
        // gccl needs to be present for handwritten clients
        $clientConfig += [
            'libName' => 'gccl',
            'transport' => $this->getDefaultTransport(),
            'emulatorHost' => null
        ];

        if ((bool) $clientConfig['emulatorHost']) {
            $emulatorConfig = $this->emulatorGapicConfig($clientConfig['emulatorHost']);
            $clientConfig = array_merge(
                $clientConfig,
                $emulatorConfig
            );
        }
        //@codeCoverageIgnoreEnd
        
        // Initialize the Gapic classes and store them in memory
        $this->gapics = [];
        foreach ($gapicClasses as $cls => $obj) {
            $this->gapics[$cls] = is_object($obj) ? $obj : new $cls($clientConfig);
        }
    }

    /**
     * Helper function that forwards the request to a gapic client obj.
     *
     * @param $gapicClassOrObj The request will be forwarded to this GAPIC.
     * @param $method This method needs to be called on the gapic obj.
     * @param $requiredArgs The positional arguments to be passed on the $method
     * @param $args The optional args.
     *
     * If a GAPIC class is provided as the first argument,
     * then the GAPIC object already stored in memory is used.
     * If a GAPIC object is supplied,then we use the object as is.
     * This is useful to override the GAPIC object used for one specific request.
     */
    public function sendReq(
        $gapicClassOrObj,
        string $method,
        array $requiredArgs,
        array $optionalArgs,
        bool $whitelisted = false
    ) {

        $allArgs = $requiredArgs;

        // we send the optional args in the end, because everything before that is
        // passed on the the `$method` as a positional argument
        $allArgs[] = $optionalArgs;

        $gapicObj = $this->getGapicObj($gapicClassOrObj);

        // TODO: check how can we simplify the use of $whitelisted
        return $this->send([$gapicObj, $method], $allArgs, $whitelisted);
    }

    /**
     * Returns the current serializer instance.
     *
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * Setter for the serializer.
     *
     * @return void
     */
    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Helper function that returns a GAPIC object stored in memory
     * using the GAPIC class as key.
     * Alternatively, if a GAPIC object is supplied, then that object is returned
     * as is.
     */
    private function getGapicObj($gapicClassOrObj)
    {
        if (is_object($gapicClassOrObj)) {
            return $gapicClassOrObj;
        }

        return $this->gapics[$gapicClassOrObj];
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
