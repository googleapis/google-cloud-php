<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\NaturalLanguage;

use Google\Cloud\NaturalLanguage\Document;

/**
 * @group naturalLanguage
 */
class DocumentTest extends \PHPUnit_Framework_TestCase
{
    private $document;
    private $entity;
    private $info;
    private $token;

    public function setUp()
    {
        $this->entity = [
            'type' => 'PERSON'
        ];
        $this->token = [
            'partOfSpeech' => [
                'tag' => 'ADJ'
            ],
            'dependencyEdge' => [
                'label' => 'P'
            ]
        ];
        $this->info = [
            'documentSentiment' => [
                'polarity' => 1
            ],
            'entities' => [
                $this->entity,
                [
                    'type' => 'EVENT'
                ]
            ],
            'tokens' => [
                $this->token,
                [
                    'partOfSpeech' => [
                        'tag' => 'NOUN'
                    ],
                    'dependencyEdge' => [
                        'label' => 'ABBREV'
                    ]
                ]
            ],
            'sentences' => [],
            'language' => 'en'
        ];
        $this->document = new Document($this->info);
    }

    public function testGetSentiment()
    {
        $this->assertEquals(1, $this->document->sentiment()['polarity']);
    }

    public function testGetInfo()
    {
        $this->assertEquals($this->info, $this->document->info());
    }

    public function testFetchesTokensByTag()
    {
        $this->assertEquals($this->token, $this->document->fetchTokensByTag('ADJ')[0]);
    }

    public function testFetchesTokensByLabel()
    {
        $this->assertEquals($this->token, $this->document->fetchTokensByLabel('P')[0]);
    }

    public function testFetchesEntitiesByType()
    {
        $this->assertEquals($this->entity, $this->document->fetchEntitiesByType('PERSON')[0]);
    }
}
