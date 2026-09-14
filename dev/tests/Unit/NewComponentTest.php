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
        service FooBarBaz {}
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
            service Speech {}
EOF;
        $new = NewComponent::fromProto($protoContents, 'google/cloud/speech/v2/speech.proto', $options);
        $this->assertEquals('CustomSpeechName', $new->componentName);
        $this->assertEquals('google.cloud.speech', $new->protoPackage);
        $this->assertEquals('Google\Cloud\Speech', $new->phpNamespace);
        $this->assertEquals('speech', $new->shortName);
        $this->assertEquals('v2', $new->version);
        $this->assertEquals('google/cloud/speech/(v2)', $new->protoPath);
    }

    public function testFromProtoWithAds()
    {
        $protoContents = <<<EOF
            package google.ads.admanager.v1;
            option (google.api.default_host) = "admanager.googleapis.com";
            option php_namespace = "Google\\\\Ads\\\\AdManager\\\\V1";
            service AdManagerService {}
EOF;
        $new = NewComponent::fromProto($protoContents, 'google/ads/admanager/v1/ad_manager.proto');
        $this->assertEquals('google.ads.admanager', $new->protoPackage);
        $this->assertEquals('Google\Ads\AdManager', $new->phpNamespace);
        $this->assertEquals('Google Ads Ad Manager', $new->displayName);
        $this->assertEquals('AdsAdManager', $new->componentName);
        $this->assertEquals('googleads/ad-manager', $new->composerPackage);
        $this->assertEquals('googleapis/php-ads-ad-manager', $new->githubRepo);
        $this->assertEquals('GPBMetadata\Google\Ads\Admanager', $new->gpbMetadataNamespace);
        $this->assertEquals('admanager', $new->shortName);
        $this->assertEquals('v1', $new->version);
        $this->assertEquals('google/ads/admanager/(v1)', $new->protoPath);

        // DataManager
        $protoContents = <<<EOF
            package google.ads.datamanager.v1;
            option (google.api.default_host) = "datamanager.googleapis.com";
            option php_namespace = "Google\\\\Ads\\\\DataManager\\\\V1";
            service DataManagerService {}
EOF;
        $new = NewComponent::fromProto($protoContents, 'google/ads/datamanager/v1/data_manager.proto');
        $this->assertEquals('AdsDataManager', $new->componentName);
        $this->assertEquals('googleads/data-manager', $new->composerPackage);
        $this->assertEquals('googleapis/php-ads-data-manager', $new->githubRepo);

        // MarketingPlatform Admin
        $protoContents = <<<EOF
            package google.ads.marketingplatform.admin.v1alpha;
            option (google.api.default_host) = "marketingplatformadmin.googleapis.com";
            option php_namespace = "Google\\\\Ads\\\\MarketingPlatform\\\\Admin\\\\V1alpha";
            service MarketingplatformAdminService {}
EOF;
        $new = NewComponent::fromProto($protoContents, 'google/ads/marketingplatform/admin/v1alpha/admin.proto');
        $this->assertEquals('AdsMarketingPlatformAdmin', $new->componentName);
        $this->assertEquals('googleads/marketingplatform-admin', $new->composerPackage);
        $this->assertEquals('googleapis/php-ads-marketingplatform-admin', $new->githubRepo);
    }

    public function testFromProtoWithCommonProtos()
    {
        $protoContents = <<<EOF
            package google.geo.type;
            option php_namespace = "Google\\\\Geo\\\\Type";
EOF;
        $new = NewComponent::fromProto($protoContents, 'google/geo/type/viewport.proto');
        $this->assertEquals('google.geo', $new->protoPackage);
        $this->assertEquals('Google\Geo', $new->phpNamespace);
        $this->assertEquals('Google Geo Common Protos', $new->displayName);
        $this->assertEquals('GeoCommonProtos', $new->componentName);
        $this->assertEquals('google/geo-common-protos', $new->composerPackage);
        $this->assertEquals('googleapis/php-geo-common-protos', $new->githubRepo);
        $this->assertEquals('', $new->shortName);
        $this->assertNull($new->version);
        $this->assertEquals('google/geo/type', $new->protoPath);

        // Shopping common protos
        $protoContents = <<<EOF
            package google.shopping.type;
            option php_namespace = "Google\\\\Shopping\\\\Type";
EOF;
        $new = NewComponent::fromProto($protoContents, 'google/shopping/type/types.proto');
        $this->assertEquals('google.shopping', $new->protoPackage);
        $this->assertEquals('Google\Shopping', $new->phpNamespace);
        $this->assertEquals('Google Shopping Common Protos', $new->displayName);
        $this->assertEquals('ShoppingCommonProtos', $new->componentName);
        $this->assertEquals('google/shopping-common-protos', $new->composerPackage);
        $this->assertEquals('googleapis/php-shopping-common-protos', $new->githubRepo);
        $this->assertEquals('', $new->shortName);
    }

    public function testFromOptionsWithAds()
    {
        $options = [
            'component-name' => 'AdsAdManager',
            'php-namespace' => 'Google\Ads\AdManager\V1',
            'proto-package' => 'google.ads.admanager.v1',
            'api-short-name' => 'admanager',
            'api-version' => 'v1',
        ];
        $new = NewComponent::fromOptions($options);
        $this->assertEquals('googleads/ad-manager', $new->composerPackage);
        $this->assertEquals('googleapis/php-ads-ad-manager', $new->githubRepo);
    }

    public function testFromOptionsWithCommonProtos()
    {
        $options = [
            'component-name' => 'GeoCommonProtos',
            'php-namespace' => 'Google\Geo',
            'proto-package' => 'google.geo',
            'api-short-name' => '',
            'api-version' => null,
        ];
        $new = NewComponent::fromOptions($options);
        $this->assertEquals('Google Geo Common Protos', $new->displayName);
        $this->assertEquals('GeoCommonProtos', $new->componentName);
        $this->assertEquals('google/geo-common-protos', $new->composerPackage);
        $this->assertEquals('googleapis/php-geo-common-protos', $new->githubRepo);
        $this->assertEquals('', $new->shortName);
    }
}
