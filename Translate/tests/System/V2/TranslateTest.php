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

namespace Google\Cloud\Translate\Tests\System\V2;

use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group translate
 */
class TranslateTest extends TranslateTestCase
{
    use AssertIsType;
    use AssertStringContains;
    use ExpectException;

    const INPUT_LANGUAGE = 'es';
    const INPUT_STRING = '¿hola, como estas?';
    const OUTPUT_STRING = 'Hello how are you doing?';

    public function testTranslate()
    {
        $client = self::$client;

        $res = $client->translate(self::INPUT_STRING);
        $this->assertEquals(self::INPUT_LANGUAGE, $res['source']);
        $this->assertEquals(self::INPUT_STRING, $res['input']);
        $this->assertEquals(self::OUTPUT_STRING, $res['text']);
        $this->assertNull($res['model']);
    }

    public function testTranslateModelNmt()
    {
        $client = self::$client;

        $res = $client->translate(self::INPUT_STRING, ['model' => 'nmt']);
        $this->assertEquals(self::INPUT_LANGUAGE, $res['source']);
        $this->assertEquals(self::INPUT_STRING, $res['input']);
        $this->assertEquals(self::OUTPUT_STRING, $res['text']);
        $this->assertEquals('nmt', $res['model']);
    }

    public function testTranslateModelBase()
    {
        $client = self::$client;

        $res = $client->translate(self::INPUT_STRING, ['model' => 'base']);
        $this->assertEquals(self::INPUT_LANGUAGE, $res['source']);
        $this->assertEquals(self::INPUT_STRING, $res['input']);
        $this->assertEquals(self::OUTPUT_STRING, $res['text']);
        $this->assertEquals('base', $res['model']);
    }

    public function testTranslateInvalidModel()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        self::$client->translate(self::INPUT_STRING, ['model' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    public function testTranslateInvalidTarget()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        self::$client->translate(self::INPUT_STRING, ['target' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    public function testTranslateInvalidSource()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        self::$client->translate(self::INPUT_STRING, ['source' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    public function testTranslateBatch()
    {
        $client = self::$client;

        $res = $client->translateBatch([self::INPUT_STRING]);
        $this->assertEquals(self::INPUT_LANGUAGE, $res[0]['source']);
        $this->assertEquals(self::INPUT_STRING, $res[0]['input']);
        $this->assertEquals(self::OUTPUT_STRING, $res[0]['text']);
        $this->assertNull($res[0]['model']);
    }

    public function testTranslateBatchModelNmt()
    {
        $client = self::$client;

        $res = $client->translateBatch([self::INPUT_STRING], ['model' => 'nmt']);
        $this->assertEquals(self::INPUT_LANGUAGE, $res[0]['source']);
        $this->assertEquals(self::INPUT_STRING, $res[0]['input']);
        $this->assertEquals(self::OUTPUT_STRING, $res[0]['text']);
        $this->assertEquals('nmt', $res[0]['model']);
    }

    public function testTranslateBatchModelBase()
    {
        $client = self::$client;

        $res = $client->translateBatch([self::INPUT_STRING], ['model' => 'base']);
        $this->assertEquals(self::INPUT_LANGUAGE, $res[0]['source']);
        $this->assertEquals(self::INPUT_STRING, $res[0]['input']);
        $this->assertEquals(self::OUTPUT_STRING, $res[0]['text']);
        $this->assertEquals('base', $res[0]['model']);
    }

    public function testTranslateBatchInvalidModel()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        self::$client->translateBatch([self::INPUT_STRING], ['model' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    public function testTranslateBatchInvalidTarget()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        self::$client->translateBatch([self::INPUT_STRING], ['target' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    public function testTranslateBatchInvalidSource()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        self::$client->translateBatch([self::INPUT_STRING], ['source' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    public function testDetectLanguage()
    {
        $client = self::$client;

        $res = $client->detectLanguage(self::INPUT_STRING);
        $this->assertEquals(self::INPUT_LANGUAGE, $res['languageCode']);
        $this->assertEquals(self::INPUT_STRING, $res['input']);
        $this->assertThat(
            $res['confidence'],
            $this->logicalOr(
                $this->isType('int'),
                $this->isType('double')
            )
        );
    }

    public function testDetectLanguageUndefined()
    {
        $client = self::$client;

        $res = $client->detectLanguage('');
        $this->assertEquals('und', $res['languageCode']);
        $this->assertEquals(1, $res['confidence']);
    }

    public function testDetectLanguageBatch()
    {
        $client = self::$client;

        $res = $client->detectLanguageBatch([self::INPUT_STRING]);
        $this->assertEquals(self::INPUT_LANGUAGE, $res[0]['languageCode']);
        $this->assertEquals(self::INPUT_STRING, $res[0]['input']);
        $this->assertThat(
            $res[0]['confidence'],
            $this->logicalOr(
                $this->isType('int'),
                $this->isType('double')
            )
        );
    }

    public function testDetectLanguageBatchUndefined()
    {
        $client = self::$client;

        $res = $client->detectLanguageBatch(['']);
        $this->assertEquals('und', $res[0]['languageCode']);
        $this->assertEquals(1, $res[0]['confidence']);
    }

    public function testDetectLanguages()
    {
        $client = self::$client;

        $res = $client->languages();
        $this->assertIsArray($res);
        $this->assertStringContainsString('en', $res);
        $this->assertStringContainsString('es', $res);
    }

    public function testLocalizedLanguages()
    {
        $client = self::$client;

        $res = $client->localizedLanguages();
        $this->assertIsArray($res);
        $this->assertStringContainsString(['code' => 'es', 'name' => 'Spanish'], $res);
        $this->assertStringContainsString(['code' => 'en', 'name' => 'English'], $res);
    }
}
