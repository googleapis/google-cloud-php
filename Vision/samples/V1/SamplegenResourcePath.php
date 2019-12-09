<?php
/*
 * Copyright 2019 Google LLC
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
 * DO NOT EDIT! This is a generated sample ("Request",  "samplegen_resource_path")
 */

// sample-metadata
//   title: Create product set (demonstrate resource paths)
//   description: Create product set (demonstrate resource paths)
//   usage: php samples/V1/SamplegenResourcePath.php [--project "[PROJECT ID]"]
// [START samplegen_resource_path]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Vision\V1\ProductSearchClient;
use Google\Cloud\Vision\V1\ProductSet;

/**
 * Create product set (demonstrate resource paths).
 *
 * @param string $project The Google Cloud Project for creating this product set
 */
function sampleCreateProductSet($project)
{
    $productSearchClient = new ProductSearchClient();

    // $project = '[PROJECT ID]';
    $formattedParent = $productSearchClient->locationName($project, 'us-central1');
    $displayName = '[DISPLAY NAME]';
    $productSet = new ProductSet();
    $productSet->setDisplayName($displayName);

    try {
        $response = $productSearchClient->createProductSet($formattedParent, $productSet);
        // The API response represents the created product set
        $productSet = $response;
        printf('The full name of the created product set: %s'.PHP_EOL, $productSet->getName());
    } finally {
        $productSearchClient->close();
    }
}
// [END samplegen_resource_path]

$opts = [
    'project::',
];

$defaultOptions = [
    'project' => '[PROJECT ID]',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$project = $options['project'];

sampleCreateProductSet($project);
