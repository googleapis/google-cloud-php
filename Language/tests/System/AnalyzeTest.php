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

namespace Google\Cloud\Language\Tests\System;

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
                                'magnitude' => 0.1,
                                'score' => 0.1,
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

    /**
     * @dataProvider analyzeEntitySentimentProvider
     */
    public function testAnalyzeEntitySentiment($text, $expectedEntities)
    {
        $result = self::$client->analyzeEntitySentiment($text);
        $info = $result->info();

        foreach ($expectedEntities as $expectedEntity) {
            $exists = false;
            foreach ($info['entities'] as $entity) {
                if ($entity['name'] == $expectedEntity['name']) {
                    $exists = true;
                    $this->assertEquals($entity['type'], $expectedEntity['type']);
                    $this->assertEquals(
                        $entity['sentiment']['score'],
                        $expectedEntity['sentiment']['score'],
                        '',
                        0.2
                    );

                    $this->assertEquals(
                        $entity['sentiment']['magnitude'],
                        $expectedEntity['sentiment']['magnitude'],
                        '',
                        0.2
                    );

                    break;
                }
            }
            $this->assertTrue($exists);
        }
    }

    public function analyzeEntitySentimentProvider()
    {
        return [
            [
                'Do you know the way to San Jose?',
                [
                    [
                        'name' => 'San Jose',
                        'type' => 'LOCATION',
                        'sentiment' => [
                            'magnitude' => 0,
                            'score' => 0,
                        ],
                    ],
                    [
                        'name' => 'way',
                        'type' => 'OTHER',
                        'sentiment' => [
                            'magnitude' => 0,
                            'score' => 0,
                        ],
                    ],
                ]
            ],
            [
                "The road to San Jose is great!",
                [
                    [
                        'name' => 'San Jose',
                        'type' => 'LOCATION',
                        'sentiment' => [
                            'magnitude' => 0.3,
                            'score' => 0.3,
                        ],
                    ],
                    [
                        'name' => 'road',
                        'type' => 'LOCATION',
                        'sentiment' => [
                            'magnitude' => 0.3,
                            'score' => 0.3,
                        ],
                    ],
                ]
            ]
        ];
    }

    public function testClassifyText()
    {
        $result = self::$client->classifyText(
            'Rafael Montero Shines in Mets’ Victory Over the Reds.Montero, who ' .
            'was demoted at midseason, took a one-hitter into the ninth inning ' .
            'as the Mets continued to dominate Cincinnati with a win at Great ' .
            'American Ball Park.'
        );
        $category = $result->categories()[0];

        $this->assertEquals('/Sports/Team Sports/Baseball', $category['name']);
        $this->assertGreaterThan(.9, $category['confidence']);
    }
}
