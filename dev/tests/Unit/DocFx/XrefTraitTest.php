<?php
/**
 * Copyright 2024 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit\DocFx;

use Google\Cloud\Dev\DocFx\Node\XrefTrait;
use PHPUnit\Framework\TestCase;

/**
 * @group dev
 */
class XrefTraitTest extends TestCase
{
    /**
     * @dataProvider provideReplaceProtoRefWithXref
     */
    public function testReplaceProtoRefWithXref(string $description, string $expected)
    {
        $xref = new class {
            use XrefTrait;
            private $protoPackages = [
                'google.cloud.aiplatform.v1' => 'Google\\Cloud\\AIPlatform\\V1',
                'google.bigtable.admin.v2' => 'Google\\Cloud\\Bigtable\\Admin\\V2',
                'google.logging.v2' => 'Google\\Cloud\\Logging\\V2',
            ];
            public function replace(string $description) {
                return $this->replaceProtoRef($description);
            }
        };

        $this->assertEquals($expected, $xref->replace($description));
    }

    public function provideReplaceProtoRefWithXref()
    {
        return [
            [
                'Testing that a [ProtoRef][google.cloud.ProtoRef] gets replaced as expected'
                 . PHP_EOL
                 . ' and so does a [SecondProtoRef][google.cloud.SecondProtoRef].',
                'Testing that a <xref uid="\Google\Cloud\ProtoRef">ProtoRef</xref> gets replaced as expected'
                 . PHP_EOL
                 . ' and so does a <xref uid="\Google\Cloud\SecondProtoRef">SecondProtoRef</xref>.',
            ],
            [
                // property reference
                '[google.cloud.Operation.name][google.cloud.Operation.name]',
                '<xref uid="\Google\Cloud\Operation::getName()">google.cloud.Operation.name</xref>',
            ],
            [
                // property with an underscore reference
                '[display_name][google.cloud.vision.v1.Product.display_name]',
                '<xref uid="\Google\Cloud\Vision\V1\Product::getDisplayName()">display_name</xref>',
            ],
            [
                // service reference
                '[Prediction service][google.cloud.aiplatform.v1.PredictionService]',
                '<xref uid="\Google\Cloud\AIPlatform\V1\Client\PredictionServiceClient">Prediction service</xref>',
            ],
            [
                // service method reference
                '[projects.locations.endpoints.predict][google.cloud.aiplatform.v1.PredictionService.Predict]',
                '<xref uid="\Google\Cloud\AIPlatform\V1\Client\PredictionServiceClient::predict()">projects.locations.endpoints.predict</xref>',
            ],
            [
                // nested class reference
                '[TextAnnotation.TextProperty][google.cloud.vision.v1.TextAnnotation.TextProperty]',
                '<xref uid="\Google\Cloud\Vision\V1\TextAnnotation\TextProperty">TextAnnotation.TextProperty</xref>',
            ],
            [
                // nested class reference with property
                '[PolicyInfo.attached_resource][google.cloud.asset.v1.BatchGetEffectiveIamPoliciesResponse.EffectiveIamPolicy.PolicyInfo.attached_resource]',
                '<xref uid="\Google\Cloud\Asset\V1\BatchGetEffectiveIamPoliciesResponse\EffectiveIamPolicy\PolicyInfo::getAttachedResource()">PolicyInfo.attached_resource</xref>',
            ],
            [
                // service methods without a "service" suffix
                '[ListBackups][google.bigtable.admin.v2.BigtableTableAdmin.ListBackups]',
                '<xref uid="\Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient::listBackups()">ListBackups</xref>'
            ],
            [
                // Enum constants
                '[google.some.Code.INVALID_ARGUMENT][google.some.Code.INVALID_ARGUMENT]',
                '<xref uid="\Google\Some\Code::INVALID_ARGUMENT">google.some.Code.INVALID_ARGUMENT</xref>'
            ],
            [
                // Numbers in the class name
                'Output only. The service account that will be used by the Log Router to access your Cloud KMS key. '
                . 'Before enabling CMEK for Log Router, you must first assign the cloudkms.cryptoKeyEncrypterDecrypter '
                . 'role to the service account that the Log Router will use to access your Cloud KMS key. Use '
                . '[GetCmekSettings][google.logging.v2.ConfigServiceV2.GetCmekSettings] to obtain the service account ID. '
                . 'See [Enabling CMEK for Log Router](https://cloud.google.com/logging/docs/routing/managed-encryption) for more information.',
                'Output only. The service account that will be used by the Log Router to access your Cloud KMS key. '
                . 'Before enabling CMEK for Log Router, you must first assign the cloudkms.cryptoKeyEncrypterDecrypter '
                . 'role to the service account that the Log Router will use to access your Cloud KMS key. Use '
                . '<xref uid="\Google\Cloud\Logging\V2\ConfigServiceV2Client::getCmekSettings()">GetCmekSettings</xref> '
                . 'to obtain the service account ID. See '
                . '[Enabling CMEK for Log Router](https://cloud.google.com/logging/docs/routing/managed-encryption) for more information.'
            ],
            [
                // Separation between links using newlines
                'Required. The [Model\'s][google.cloud.aiplatform.v1.BatchPredictionJob.model]' . PHP_EOL
                . '[PredictSchemata\'s][google.cloud.aiplatform.v1.Model.predict_schemata]' . PHP_EOL
                . '[instance_schema_uri][google.cloud.aiplatform.v1.PredictSchemata.instance_schema_uri].',
                'Required. The <xref uid="\Google\Cloud\AIPlatform\V1\BatchPredictionJob::getModel()">Model\'s</xref>' . PHP_EOL
                . '<xref uid="\Google\Cloud\AIPlatform\V1\Model::getPredictSchemata()">PredictSchemata\'s</xref>' . PHP_EOL
                . '<xref uid="\Google\Cloud\AIPlatform\V1\PredictSchemata::getInstanceSchemaUri()">instance_schema_uri</xref>.'
            ],
            [
                // Separation within links using newlines
                'Required. The [Model\'s]' . PHP_EOL . '[google.cloud.aiplatform.v1.BatchPredictionJob.model]'
                . ' [PredictSchemata\'s]' . PHP_EOL . '[google.cloud.aiplatform.v1.Model.predict_schemata]'
                . ' [instance_schema_uri]' . PHP_EOL . '[google.cloud.aiplatform.v1.PredictSchemata.instance_schema_uri].',
                'Required. The <xref uid="\Google\Cloud\AIPlatform\V1\BatchPredictionJob::getModel()">Model\'s</xref>'
                . ' <xref uid="\Google\Cloud\AIPlatform\V1\Model::getPredictSchemata()">PredictSchemata\'s</xref>'
                . ' <xref uid="\Google\Cloud\AIPlatform\V1\PredictSchemata::getInstanceSchemaUri()">instance_schema_uri</xref>.'
            ],
            [
                // Separation within links using a space - some APIs do this :/
                'Required. The [Model\'s] [google.cloud.aiplatform.v1.BatchPredictionJob.model]'
                . ' [PredictSchemata\'s] [google.cloud.aiplatform.v1.Model.predict_schemata]'
                . ' [instance_schema_uri] [google.cloud.aiplatform.v1.PredictSchemata.instance_schema_uri].',
                'Required. The <xref uid="\Google\Cloud\AIPlatform\V1\BatchPredictionJob::getModel()">Model\'s</xref>'
                . ' <xref uid="\Google\Cloud\AIPlatform\V1\Model::getPredictSchemata()">PredictSchemata\'s</xref>'
                . ' <xref uid="\Google\Cloud\AIPlatform\V1\PredictSchemata::getInstanceSchemaUri()">instance_schema_uri</xref>.'
            ],
            [
                'Testing that a code sample like $foo["bar"]["baz"] does not get replaced',
                'Testing that a code sample like $foo["bar"]["baz"] does not get replaced'
            ],
            [
                '[1][1] should not get replaced',
                '[1][1] should not get replaced',
            ],
            [
                '[package with underscore][package.with_underscore.Class] should get replaced',
                '<xref uid="\Package\With_underscore\Class">package with underscore</xref> should get replaced',
            ],
            [
                '[property with numbers][Class.property123] should get replaced',
                '<xref uid="\Class::getProperty123()">property with numbers</xref> should get replaced',
            ],
            [
                '[constant with numbers][Class.CONST123] should get replaced',
                '<xref uid="\Class::CONST123">constant with numbers</xref> should get replaced',
            ],
        ];
    }

    public function testProtoRefUsingPackageName()
    {
        $description = '[ListBackups][google.bigtable.admin.v2.BigtableTableAdmin.ListBackups]';
        $protoPackages = ['google.bigtable.admin.v2' => 'Google\\Cloud\\Bigtable\\Admin\\V2'];

        $xref = new class {
            use XrefTrait;
            public $protoPackages;
            public function replace(string $description) {
                return $this->replaceProtoRef($description);
            }
        };

        $xref->protoPackages = $protoPackages;

        $this->assertEquals(
            '<xref uid="\Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient::listBackups()">ListBackups</xref>',
            $xref->replace($description)
        );
    }
}
