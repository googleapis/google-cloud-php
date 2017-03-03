<?php

/**
 * Copyright 2015 Google Inc.
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
namespace Google\Cloud\AppEngine;

/*
 * The AppIdentityS class is automatically defined on App Engine,
 * so including this dependency is not necessary, and will result in a
 * PHP fatal error in the App Engine environment.
 */
use google\appengine\api\app_identity\AppIdentityService;

/**
 * A wrapper for the AppEngine AppIdentity service
 * This class will only work when running on AppEngine, or
 * if the App Engine SDK is available.
 *
 * ```
 * use Google\Cloud\AppEngine\AppIdentity;
 *
 * $appIdentity = new AppIdentity();
 * $projectId = $identity->getApplicationId();
 * ```
 */
class AppIdentity
{
    /**
     * Get the current application ID from the App Identity Service
     *
     * Example:
     * ```
     * $projectId = $appIdentity->getApplicationId();
     * ```
     *
     * @return string
     */
    public function getApplicationId()
    {
        if (!class_exists('google\appengine\api\app_identity\AppIdentityService')) {
            throw new \Exception('This class must be run in App Engine');
        }

        return AppIdentityService::getApplicationId();
    }
}
