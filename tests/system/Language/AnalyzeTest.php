<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\System\Language;

/**
 * @group language
 */
class AnalyzeTest extends LanguageTestCase
{
    /**
     * @dataProvider analyzeSyntaxProvider
     */
    public function testAnalyzeSyntax($text, $expectedValues)
    {
        $result = self::$client->analyzeSyntax($text);
        $info = $result->info();

        foreach ($expectedValues as $key => $expected) {
            $this->assertEquals($expected, $info[$key]);
        }
    }

    public function analyzeSyntaxProvider()
    {
        return [
            [
                'Do you know the way to San Jose?',
                [
                    'sentences' => [
                        [
                            'text' => [
                                'content' => 'Do you know the way to San Jose?',
                                'beginOffset' => 0,
                            ]
                        ]
                    ],
                    'entities' => [],
                    'language' => 'en'
                ]
            ]
        ];
    }

    /**
     * @dataProvider analyzeSentimentProvider
     */
    public function testAnalyzeSentiment($text, $expectedValues)
    {
        $result = self::$client->analyzeSentiment($text);
        $info = $result->info();

        foreach ($expectedValues as $key => $expected) {
            $this->assertEquals($expected, $info[$key]);
        }
    }

    public function analyzeSentimentProvider()
    {
        return [
            [
                'Do you know the way to San Jose?',
                [
                    'sentences' => [
                        [
                            'text' => [
                                'content' => 'Do you know the way to San Jose?',
                                'beginOffset' => 0,
                            ],
                            'sentiment' => [
                                'magnitude' => 0,
                                'score' => 0,
                            ],
                        ]
                    ],
                    'language' => 'en'
                ]
            ]
        ];
    }

    /**
     * @dataProvider analyzeEntitiesProvider
     */
    public function testAnalyzeEntities($text, $expectedEntities)
    {
        $result = self::$client->analyzeEntities($text);
        $info = $result->info();

        foreach ($expectedEntities as $expectedEntity) {
            $exists = false;
            foreach ($info['entities'] as $entity) {
                if ($entity['name'] == $expectedEntity['name']) {
                    $exists = true;
                    $this->assertEquals($entity['type'], $expectedEntity['type']);
                    break;
                }
            }
            $this->assertTrue($exists);
        }
    }

    public function analyzeEntitiesProvider()
    {
        return [
            [
                'Do you know the way to San Jose?',
                [
                    [
                        'name' => 'San Jose',
                        'type' => 'LOCATION',
                    ],
                    [
                        'name' => 'way',
                        'type' => 'OTHER',
                    ],
                ]
            ]
        ];
    }
}
