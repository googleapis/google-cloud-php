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

namespace Google\Auth;

/**
 * Interface for custom subject token suppliers used in OIDC/SAML external
 * account credentials programmatic refresh.
 */
interface SubjectTokenSupplierInterface
{
    /**
     * Gets a valid subject token requested from a third-party identity provider.
     *
     * The supplier is responsible for caching the subject token and refreshing
     * it when expired.
     *
     * @param ExternalAccountSupplierContext $context The context containing the audience and subject token type.
     * @param callable|null $httpHandler An optional HTTP handler for making network requests.
     * @return string The valid subject token.
     */
    public function getSubjectToken(
        ExternalAccountSupplierContext $context,
        ?callable $httpHandler = null
    ): string;
}
