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
 * DO NOT EDIT! This is a generated sample ("Request",  "samplegen_basics")
 */

// sample-metadata
//   title: This is the sample title
//   description: This is the sample description
//   usage: php samples/V1/SamplegenBasics.php [--display_name "This is the default value of the display_name request field"]
// [START samplegen_basics]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Vision\V1\ProductSearchClient;
use Google\Cloud\Vision\V1\ProductSet;

/** This is the sample description */
function sampleCreateProductSet($displayName)
{
    $productSearchClient = new ProductSearchClient();

    // $displayName = 'This is the default value of the display_name request field';

    // The project and location in which the product set should be created.
    $formattedParent = $productSearchClient->locationName('[PROJECT]', '[LOCATION]');
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
// [END samplegen_basics]

$opts = [
    'display_name::',
];

$defaultOptions = [
    'display_name' => 'This is the default value of the display_name request field',
];

$options = getopt('', $opts);
$options += $defaultOptions;

$displayName = $options['display_name'];

sampleCreateProductSet($displayName);
