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

use Google\Cloud\Language\V2\AnalyzeEntitiesRequest;
use Google\Cloud\Language\V2\AnalyzeSentimentRequest;
use Google\Cloud\Language\V2\ClassifyTextRequest;
use Google\Cloud\Language\V2\Document;
use Google\Cloud\Language\V2\EncodingType;
use Google\Cloud\Language\V2\Entity;

/**
 * @group language
 */
class AnalyzeTest extends LanguageTestCase
{
    /**
     * @dataProvider analyzeSentimentProvider
     */
    public function testAnalyzeSentiment($text, $expectedValues)
    {
        $request = (new AnalyzeSentimentRequest())
            ->setDocument(new Document([
                'content' => $text,
                'type' => Document\Type::PLAIN_TEXT
            ]))
            ->setEncodingType(EncodingType::UTF8);
        $result = self::$client->analyzeSentiment($request);

        $this->assertEqualsWithDelta($expectedValues['language'], $result->getLanguageCode(), 0.2);

        $sentences = $result->getSentences();
        $this->assertCount(count($expectedValues['sentences']), $sentences);

        foreach ($expectedValues['sentences'] as $i => $expectedSentence) {
            $sentence = $sentences[$i];
            $this->assertEquals($expectedSentence['text']['content'], $sentence->getText()->getContent());
            $this->assertEquals($expectedSentence['text']['beginOffset'], $sentence->getText()->getBeginOffset());
            $this->assertEqualsWithDelta(
                $expectedSentence['sentiment']['magnitude'],
                $sentence->getSentiment()->getMagnitude(),
                0.2
            );
            $this->assertEqualsWithDelta(
                $expectedSentence['sentiment']['score'],
                $sentence->getSentiment()->getScore(),
                0.2
            );
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
        $request = (new AnalyzeEntitiesRequest())
            ->setDocument(new Document([
                'content' => $text,
                'type' => Document\Type::PLAIN_TEXT,
            ]));

        $result = self::$client->analyzeEntities($request);
        $entities = $result->getEntities();

        foreach ($expectedEntities as $expectedEntity) {
            $exists = false;
            foreach ($entities as $entity) {
                if ($entity->getName() == $expectedEntity['name']) {
                    $exists = true;
                    $this->assertEquals(Entity\Type::value($expectedEntity['type']), $entity->getType());
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

    public function testClassifyText()
    {
        $text = 'Rafael Montero Shines in Mets’ Victory Over the Reds.Montero, who ' .
            'was demoted at midseason, took a one-hitter into the ninth inning ' .
            'as the Mets continued to dominate Cincinnati with a win at Great ' .
            'American Ball Park.';
        $request = (new ClassifyTextRequest())
            ->setDocument(new Document([
                'content' => $text,
                'type' => Document\Type::PLAIN_TEXT,
            ]));
        $result = self::$client->classifyText($request);
        $categories = $result->getCategories();
        $category = $categories[0];

        $this->assertEquals('/Sports/Team Sports/Baseball', $category->getName());
        $this->assertGreaterThan(.9, $category->getConfidence());
    }
}
