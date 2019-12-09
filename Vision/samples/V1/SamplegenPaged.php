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
 * DO NOT EDIT! This is a generated sample ("RequestPagedAll",  "samplegen_paged")
 */

// sample-metadata
//   title: List product sets
//   description: List product sets
//   usage: php samples/V1/SamplegenPaged.php
// [START samplegen_paged]
require __DIR__.'/../../vendor/autoload.php';

use Google\Cloud\Vision\V1\ProductSearchClient;

/** List product sets */
function sampleListProductSets()
{
    $productSearchClient = new ProductSearchClient();

    // The project and location where the product sets are contained.
    $formattedParent = $productSearchClient->locationName('[PROJECT]', '[LOCATION]');

    try {
        // Iterate through all elements
        $pagedResponse = $productSearchClient->listProductSets($formattedParent);
        foreach ($pagedResponse->iterateAllElements() as $responseItem) {
            // The entity in this iteration represents a product set
            $productSet = $responseItem;
            printf('The full name of this product set: %s'.PHP_EOL, $productSet->getName());
        }
    } finally {
        $productSearchClient->close();
    }
}
// [END samplegen_paged]

sampleListProductSets();
