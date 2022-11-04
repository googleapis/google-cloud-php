<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Translate\Tests\Unit\V2;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Translate\V2\Connection\ConnectionInterface;
use Google\Cloud\Translate\V2\TranslateClient;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * @group translate
 */
class TranslateClientTest extends TestCase
{
    private $client;
    private $connection;
    private $key = 'test_key';

    public function set_up()
    {
        $this->client = TestHelpers::stub(TranslateClient::class, [
            ['key' => $this->key]
        ]);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testWithNoKey()
    {
        $client = TestHelpers::stub(TranslateClient::class);

        $this->connection->listTranslations(Argument::that(function ($args) {
            return !isset($args['key']);
        }))->shouldBeCalled()->willReturn([]);

        $client->___setProperty('connection', $this->connection->reveal());

        $client->translate('foo');
    }

    public function testTranslateModel()
    {
        $this->connection->listTranslations(Argument::that(function ($args) {
            if (isset($args['model'])) {
                return false;
            }
        }));

        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->client->translate('foo bar');

        $this->connection->listTranslations(Argument::withEntry('model', 'base'));

        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->client->translate('foo bar', ['model' => 'base']);
    }

    public function testTranslate()
    {
        $expected = $this->getTranslateExpectedData('translate', 'translated', 'en');
        $options = [
            'source' => $expected['source'],
            'target' => 'de',
            'format' => 'text',
            'model' => 'base'
        ];
        $this->connection->listTranslations($options + [
            'q' => [$expected['input']],
            'key' => $this->key
        ])->willReturn([
            'data' => [
                'translations' => [
                    $this->getTranslateApiData($expected['text'])
                ]
            ]
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $translation = $this->client->translate($expected['input'], $options);

        $this->assertEquals($expected, $translation);
    }

    public function testTranslateWithNmtModel()
    {
        $expected = $this->getTranslateExpectedData('translate', 'translated', 'en', 'nmt');

        $options = [
            'source' => $expected['source'],
            'target' => 'de',
            'format' => 'text',
            'model' => 'nmt'
        ];
        $this->connection
            ->listTranslations($options + [
                'q' => [$expected['input']],
                'key' => $this->key
            ])
            ->willReturn([
                'data' => [
                    'translations' => [
                        $this->getTranslateApiData($expected['text'], null, 'nmt')
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $translation = $this->client->translate($expected['input'], $options);

        $this->assertEquals($expected, $translation);
    }

    public function testTranslateBatch()
    {
        $expected1 = $this->getTranslateExpectedData('translate', 'translated', 'en');
        $expected2 = $this->getTranslateExpectedData('translate2', 'translated2', 'en');
        $stringsToTranslate = [$expected1['input'], $expected2['input']];
        $target = 'de';
        $this->connection
            ->listTranslations([
                'target' => $target,
                'q' => $stringsToTranslate,
                'key' => $this->key,
                'model' => 'base'
            ])
            ->willReturn([
                'data' => [
                    'translations' => [
                        $this->getTranslateApiData($expected1['text'], $expected1['source']),
                        $this->getTranslateApiData($expected2['text'], $expected2['source'])
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1);
        $client = TestHelpers::stub(TranslateClient::class, [
            ['key' => $this->key, 'target' => $target]
        ]);
        $client->___setProperty('connection', $this->connection->reveal());
        $translations = $client->translateBatch($stringsToTranslate, ['model' => 'base']);

        $this->assertEquals($expected1, $translations[0]);
        $this->assertEquals($expected2, $translations[1]);
    }

    public function testTranslateBatchWithNotZeroIndexedInput()
    {
        $expected1 = $this->getTranslateExpectedData('translate', 'translated', 'en');
        $expected2 = $this->getTranslateExpectedData('translate2', 'translated2', 'en');
        $stringsToTranslate = [1 => $expected1['input'], 2 => $expected2['input']];

        $target = 'de';
        $this->connection->listTranslations([
            'target' => $target,
            'q' => $stringsToTranslate,
            'key' => $this->key,
            'model' => 'base'
        ])->willReturn([
            'data' => [
                'translations' => [
                    $this->getTranslateApiData($expected1['text'], $expected1['source']),
                    $this->getTranslateApiData($expected2['text'], $expected2['source'])
                ]
            ]
        ])->shouldBeCalledTimes(1);

        $client = TestHelpers::stub(TranslateClient::class, [
            ['key' => $this->key, 'target' => $target]
        ]);
        $client->___setProperty('connection', $this->connection->reveal());
        $translations = $client->translateBatch($stringsToTranslate, ['model' => 'base']);

        $this->assertEquals($expected1, $translations[0]);
        $this->assertEquals($expected2, $translations[1]);
    }

    public function testDetectLanguage()
    {
        $expected = $this->getDetectionExpectedData('text', 'en', .5);
        $options = ['format' => 'text'];
        $this->connection
            ->listDetections($options + [
                'q' => [$expected['input']],
                'key' => $this->key
            ])
            ->willReturn([
                'data' => [
                    'detections' => [
                        $this->getDetectionApiData($expected['languageCode'], $expected['confidence'])
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $detection = $this->client->detectLanguage($expected['input'], $options);

        $this->assertEquals($expected, $detection);
    }

    public function testDetectLanguageBatch()
    {
        $expected1 = $this->getDetectionExpectedData('text', 'en', .5);
        $expected2 = $this->getDetectionExpectedData('text2', 'en', .7);
        $stringsToDetect = [$expected1['input'], $expected2['input']];
        $this->connection
            ->listDetections([
                'q' => $stringsToDetect,
                'key' => $this->key
            ])
            ->willReturn([
                'data' => [
                    'detections' => [
                        $this->getDetectionApiData($expected1['languageCode'], $expected1['confidence']),
                        $this->getDetectionApiData($expected2['languageCode'], $expected2['confidence'])
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $detections = $this->client->detectLanguageBatch($stringsToDetect);

        $this->assertEquals($expected1, $detections[0]);
        $this->assertEquals($expected2, $detections[1]);
    }

    public function testLocalizedLanguages()
    {
        $expected = [
            'code' => 'es',
            'name' => 'Spanish'
        ];
        $target = 'fr';
        $this->connection
            ->listLanguages([
                'target' => $target,
                'key' => $this->key
            ])
            ->willReturn([
                'data' => [
                    'languages' => [
                        $this->getLanguageApiData($expected['code'], $expected['name'])
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $languages = $this->client->localizedLanguages(['target' => $target]);

        $this->assertEquals($expected, $languages[0]);
    }

    public function testLanguages()
    {
        $expectedLanguage = 'es';
        $this->connection
            ->listLanguages([
                'target' => null,
                'key' => $this->key
            ])
            ->willReturn([
                'data' => [
                    'languages' => [
                        $this->getLanguageApiData($expectedLanguage)
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $languages = $this->client->languages();

        $this->assertEquals($expectedLanguage, $languages[0]);
    }

    private function getTranslateApiData($translatedText, $source = null, $model = 'base')
    {
        return array_filter([
            'translatedText' => $translatedText,
            'detectedSourceLanguage' => $source,
            'model' => $model
        ]);
    }

    private function getTranslateExpectedData($textToTranslate, $translatedText, $source, $model = 'base')
    {
        return [
            'text' => $translatedText,
            'source' => $source,
            'input' => $textToTranslate,
            'model' => $model
        ];
    }

    private function getDetectionApiData($language, $confidence)
    {
        return array_filter([
            [
                'language' => $language,
                'isReliable' => false,
                'confidence' => $confidence
            ]
        ]);
    }

    private function getDetectionExpectedData($textToDetect, $detectedLanguage, $confidence = null)
    {
        return array_filter([
            'input' => $textToDetect,
            'languageCode' => $detectedLanguage,
            'confidence' => $confidence
        ]);
    }

    private function getLanguageApiData($languageCode, $name = null)
    {
        return array_filter([
            'language' => $languageCode,
            'name' => $name
        ]);
    }
}
