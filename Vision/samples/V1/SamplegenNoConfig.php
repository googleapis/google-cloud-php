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
 * DO NOT EDIT! This is a generated sample ("Request",  "samplegen_no_config")
 */

// sample-metadata
//   title:
//   usage: php samples/V1/SamplegenNoConfig.php
// [START ]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Vision\V1\ProductSearchClient;
use Google\Cloud\Vision\V1\ProductSet;

function sampleCreateProductSet()
{
    $productSearchClient = new ProductSearchClient();

    $formattedParent = $productSearchClient->locationName('[PROJECT]', '[LOCATION]');
    $productSet = new ProductSet();

    try {
        $response = $productSearchClient->createProductSet($formattedParent, $productSet);
        printf('%s'.PHP_EOL, print_r($response, true));
    } finally {
        $productSearchClient->close();
    }
}
// [END ]

sampleCreateProductSet();
