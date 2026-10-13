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

use Google\Auth\ExternalAccountCredentialSourceInterface;
use Google\Auth\ExternalAccountSupplierContext;
use Google\Auth\HttpHandler\HttpClientCache;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Auth\SubjectTokenSupplierInterface;

/**
 * Authenticates requests using a custom subject token supplier.
 */
class SubjectTokenSupplierSource implements ExternalAccountCredentialSourceInterface
{
    /**
     * @var SubjectTokenSupplierInterface|callable
     */
    private $supplier;
    private ExternalAccountSupplierContext $context;

    /**
     * @param SubjectTokenSupplierInterface|callable $supplier
     * @param ExternalAccountSupplierContext $context
     */
    public function __construct(
        SubjectTokenSupplierInterface|callable $supplier,
        ExternalAccountSupplierContext $context
    ) {
        $this->supplier = $supplier;
        $this->context = $context;
    }

    public function fetchSubjectToken(?callable $httpHandler = null): string
    {
        if (is_null($httpHandler)) {
            $httpHandler = HttpHandlerFactory::build(HttpClientCache::getHttpClient());
        }

        if ($this->supplier instanceof SubjectTokenSupplierInterface) {
            return $this->supplier->getSubjectToken($this->context, $httpHandler);
        }

        return ($this->supplier)($this->context, $httpHandler);
    }

    public function getCacheKey(): ?string
    {
        if (is_object($this->supplier)) {
            return spl_object_hash($this->supplier);
        }
        if (is_string($this->supplier)) {
            return $this->supplier;
        }

        return null;
    }
}
