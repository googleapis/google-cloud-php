<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\System\Translate;

/**
 * @group translate
 */
class TranslateTest extends TranslateTestCase
{
    const INPUT_LANGUAGE = 'es';
    const INPUT_STRING = '¿hola, como estas?';
    const OUTPUT_STRING = 'Hello how are you?';

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

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testTranslateInvalidModel()
    {
        self::$client->translate(self::INPUT_STRING, ['model' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testTranslateInvalidTarget()
    {
        self::$client->translate(self::INPUT_STRING, ['target' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testTranslateInvalidSource()
    {
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

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testTranslateBatchInvalidModel()
    {
        self::$client->translateBatch([self::INPUT_STRING], ['model' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testTranslateBatchInvalidTarget()
    {
        self::$client->translateBatch([self::INPUT_STRING], ['target' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testTranslateBatchInvalidSource()
    {
        self::$client->translateBatch([self::INPUT_STRING], ['source' => 'thisDoesntActuallyExistSoGimmeErrorPlease']);
    }

    public function testDetectLanguage()
    {
        $client = self::$client;

        $res = $client->detectLanguage(self::INPUT_STRING);
        $this->assertEquals(self::INPUT_LANGUAGE, $res['languageCode']);
        $this->assertEquals(self::INPUT_STRING, $res['input']);
        $this->assertTrue(is_double($res['confidence']));
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
        $this->assertTrue(is_double($res[0]['confidence']));
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
        $this->assertTrue(is_array($res));
        $this->assertTrue(in_array('en', $res));
        $this->assertTrue(in_array('es', $res));
    }

    public function testLocalizedLanguages()
    {
        $client = self::$client;

        $res = $client->localizedLanguages();
        $this->assertTrue(is_array($res));
        $this->assertTrue(in_array(['code' => 'es', 'name' => 'Spanish'], $res));
        $this->assertTrue(in_array(['code' => 'en', 'name' => 'English'], $res));
    }
}
