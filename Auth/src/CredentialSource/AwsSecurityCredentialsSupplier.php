<?php
/*
 * Copyright 2026 Google Inc.
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

namespace Google\Auth\CredentialSource;

use Google\Auth\AwsSecurityCredentials;
use Google\Auth\AwsSecurityCredentialsSupplierInterface;
use Google\Auth\ExternalAccountSupplierContext;
use Google\Auth\HttpHandler\HttpClientCache;
use Google\Auth\HttpHandler\HttpHandlerFactory;

/**
 * Default AWS security credentials supplier that resolves credentials and
 * region from environment variables, ECS container metadata, or EC2 IMDS.
 */
class AwsSecurityCredentialsSupplier implements AwsSecurityCredentialsSupplierInterface
{
    private ?string $imdsV2SessionToken = null;

    public function __construct(
        private ?string $regionUrl = null,
        private ?string $securityCredentialsUrl = null,
        private ?string $imdsv2SessionTokenUrl = null
    ) {
    }

    public function getCredentials(
        ExternalAccountSupplierContext $context,
        ?callable $httpHandler = null
    ): AwsSecurityCredentials {
        if (is_null($httpHandler)) {
            $httpHandler = HttpHandlerFactory::build(HttpClientCache::getHttpClient());
        }

        $signingVars = AwsNativeSource::getSigningVarsFromEnv()
            ?? AwsNativeSource::getSigningVarsFromEcs($httpHandler);

        if (!$signingVars) {
            if (!$this->securityCredentialsUrl) {
                throw new \LogicException(
                    'Unable to get credentials from ENV, and no security credentials URL provided'
                );
            }
            $headers = $this->getImdsV2Headers($httpHandler, true);
            $signingVars = AwsNativeSource::getSigningVarsFromUrl(
                $httpHandler,
                $this->securityCredentialsUrl,
                AwsNativeSource::getRoleName($httpHandler, $this->securityCredentialsUrl, $headers),
                $headers
            );
        }

        [$accessKeyId, $secretAccessKey, $securityToken] = $signingVars;

        return new AwsSecurityCredentials($accessKeyId, $secretAccessKey, $securityToken);
    }

    public function getRegion(
        ExternalAccountSupplierContext $context,
        ?callable $httpHandler = null
    ): string {
        if (is_null($httpHandler)) {
            $httpHandler = HttpHandlerFactory::build(HttpClientCache::getHttpClient());
        }

        try {
            if (!$region = AwsNativeSource::getRegionFromEnv()) {
                if (!$this->regionUrl) {
                    throw new \LogicException('Unable to get region from ENV, and no region URL provided');
                }
                $headers = $this->getImdsV2Headers($httpHandler, false);
                $region = AwsNativeSource::getRegionFromUrl($httpHandler, $this->regionUrl, $headers);
            }

            return $region;
        } finally {
            $this->imdsV2SessionToken = null;
        }
    }

    /**
     * @return array<string, string>
     */
    private function getImdsV2Headers(callable $httpHandler, bool $cacheSessionToken): array
    {
        if (!$this->imdsv2SessionTokenUrl) {
            return [];
        }

        $token = $this->imdsV2SessionToken
            ?? AwsNativeSource::getImdsV2SessionToken($this->imdsv2SessionTokenUrl, $httpHandler);

        if ($cacheSessionToken) {
            $this->imdsV2SessionToken = $token;
        }

        return [
            'X-aws-ec2-metadata-token' => $token,
        ];
    }
}
