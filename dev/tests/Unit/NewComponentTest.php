<?php
/**
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit;

use Google\Cloud\Dev\NewComponent;
use PHPUnit\Framework\TestCase;

/**
 */
class NewComponentTest extends TestCase
{
    private string $protoMinimum = <<<EOF
        package foo.bar.baz;
        option (google.api.default_host) = "foobarbaz.googleapis.com";
    EOF;

    /**
     * @dataProvider provideFromProto
     */
    public function testFromProto(string $protoPath, array $details)
    {
        $protoFixture = __DIR__ . '/../' . $protoPath;
        $protoContents = file_exists($protoFixture) ? file_get_contents($protoFixture) : $this->protoMinimum;
        $new = NewComponent::fromProto($protoContents, $protoPath);
        $details += [
            'protoPackage' => 'foo.bar.baz',
            'phpNamespace' => 'Foo\Bar\Baz',
            'displayName'  => 'Foo Bar Baz',
            'componentName' => 'FooBarBaz',
            'composerPackage' => 'google/foo-bar-baz',
            'githubRepo' => 'googleapis/php-foo-bar-baz',
            'gpbMetadataNamespace' => 'GPBMetadata\Foo\Bar\Baz',
            'shortName' => 'foobarbaz',
        ];
        $this->assertEquals($details['protoPackage'], $new->protoPackage);
        $this->assertEquals($details['phpNamespace'], $new->phpNamespace);
        $this->assertEquals($details['displayName'], $new->displayName);
        $this->assertEquals($details['componentName'], $new->componentName);
        $this->assertEquals($details['composerPackage'], $new->composerPackage);
        $this->assertEquals($details['githubRepo'], $new->githubRepo);
        $this->assertEquals($details['gpbMetadataNamespace'], $new->gpbMetadataNamespace);
        $this->assertEquals($details['shortName'], $new->shortName);
        $this->assertEquals($details['protoPath'], $new->protoPath);
        $this->assertEquals($details['version'], $new->version);
    }

    public function provideFromProto()
    {
        return [
            [
                'fixtures/proto/example.proto',
                [
                    'protoPackage' => 'example',
                    'phpNamespace' => 'Example',
                    'displayName' => 'Example',
                    'componentName' => 'Example',
                    'composerPackage' => 'google/example',
                    'githubRepo' => 'googleapis/php-example',
                    'gpbMetadataNamespace' => 'GPBMetadata\\Example',
                    'shortName' => 'example',
                    'protoPath' => 'fixtures/proto',
                    'version' => null,
                ]
            ],
            [
                'foo/bar/v1/admin.proto',
                ['version' => 'v1', 'protoPath' => 'foo/bar/(v1)']
            ],
            [
                'foo/bar/v2/admin/admin.proto',
                ['version' => 'v2', 'protoPath' => 'foo/bar/(v2)/admin']
            ],
            [
                'foo/bar/v2beta1/admin/admin.proto',
                ['version' => 'v2beta1', 'protoPath' => 'foo/bar/(v2beta1)/admin']
            ],
            [
                'foo/bar/v1p1beta1/admin/admin.proto',
                ['version' => 'v1p1beta1', 'protoPath' => 'foo/bar/(v1p1beta1)/admin']
            ],
            [
                'foo/v2/admin/v1/admin.proto',
                ['version' => 'v1', 'protoPath' => 'foo/v2/admin/(v1)']
            ],
            [
                'foo/bar/admin/admin.proto',
                ['version' => null, 'protoPath' => 'foo/bar/admin']
            ],
            [
                'foo/bar/v1prev1/admin.proto',
                ['version' => null, 'protoPath' => 'foo/bar/v1prev1']
            ],
            [
                'foo/bar/v1a/admin.proto',
                ['version' => null, 'protoPath' => 'foo/bar/v1a']
            ],
        ];
    }

    public function testFromOptions()
    {
        $options = [
            'component-name' => 'Speech',
            'php-namespace' => 'Google\Cloud\Speech\V2',
            'proto-package' => 'google.cloud.speech.v2',
            'api-short-name' => 'speech',
            'api-version' => 'v2',
        ];
        $new = NewComponent::fromOptions($options);
        $this->assertEquals('google.cloud.speech.v2', $new->protoPackage);
        $this->assertEquals('Google\Cloud\Speech\V2', $new->phpNamespace);
        $this->assertEquals('Google Cloud Speech V2', $new->displayName);
        $this->assertEquals('Speech', $new->componentName);
        $this->assertEquals('google/cloud-speech-v2', $new->composerPackage);
        $this->assertEquals('googleapis/google-cloud-php-speech-v2', $new->githubRepo);
        $this->assertEquals('GPBMetadata\Google\Cloud\Speech\V2', $new->gpbMetadataNamespace);
        $this->assertEquals('speech', $new->shortName);
        $this->assertEquals('v2', $new->version);
        $this->assertEquals('', $new->protoPath);
    }

    public function testFromOptionsWithUnversionedApi()
    {
        $options = [
            'component-name' => 'Speech',
            'php-namespace' => 'Google\Cloud\Speech',
            'proto-package' => 'google.cloud.speech',
            'api-short-name' => 'speech',
            'api-version' => null,
        ];
        $new = NewComponent::fromOptions($options);
        $this->assertNull($new->version);
        $this->assertEquals('Google\Cloud\Speech', $new->phpNamespace);
        $this->assertEquals('Google Cloud Speech', $new->displayName);
    }

    public function testFromProtoWithOptionOverrides()
    {
        $options = [
            'component-name' => 'CustomSpeechName',
        ];
        $protoContents = <<<EOF
            package google.cloud.speech.v2;
            option (google.api.default_host) = "speech.googleapis.com";
            option php_namespace = "Google\\\\Cloud\\\\Speech\\\\V2";
EOF;
        $new = NewComponent::fromProto($protoContents, 'google/cloud/speech/v2/speech.proto', $options);
        $this->assertEquals('CustomSpeechName', $new->componentName);
        $this->assertEquals('google.cloud.speech.v2', $new->protoPackage);
        $this->assertEquals('Google\Cloud\Speech\V2', $new->phpNamespace);
        $this->assertEquals('speech', $new->shortName);
        $this->assertEquals('v2', $new->version);
        $this->assertEquals('google/cloud/speech/(v2)', $new->protoPath);
    }
}