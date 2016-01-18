<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage\Connection;

interface ConnectionInterface
{
    public function deleteAcl(array $options = []);

    public function getAcl(array $options = []);

    public function listAcl(array $options = []);

    public function insertAcl(array $options = []);

    public function patchAcl(array $options = []);

    public function deleteBucket(array $options = []);

    public function getBucket(array $options = []);

    public function listBuckets(array $options = []);

    public function createBucket($options = []);

    public function patchBucket(array $options = []);

    public function deleteObject(array $options = []);

    public function getObject(array $options = []);

    public function listObjects(array $options = []);

    public function patchObject(array $options = []);

    public function downloadObject(array $options = []);

    public function uploadObject(array $options = []);
}
