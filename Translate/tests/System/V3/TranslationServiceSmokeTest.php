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
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Cloud\Translate\Tests\System\V3;

use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Translate\V3\TranslationServiceClient;

/**
 * @group translate
 * @group gapic
 */
class TranslationServiceSmokeTest extends SystemTestCase
{
    /**
     * @test
     */
    public function smokeTest()
    {
        $projectId = getenv('PROJECT_ID');
        if ($projectId === false) {
            $this->fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        $client = new TranslationServiceClient();
        $res = $client->translateText(
            ['one'],
            'es',
            $client->locationName($projectId, 'global')
        );

        $this->assertEquals(
            'una',
            $res->getTranslations()[0]->getTranslatedText()
        );
    }
}
