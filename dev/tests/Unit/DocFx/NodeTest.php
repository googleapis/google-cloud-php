<?php
/**
 * Copyright 2022 Google LLC
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

use PHPUnit\Framework\TestCase;
use Google\Cloud\Dev\DocFx\Node\ClassNode;
use Google\Cloud\Dev\DocFx\Node\MethodNode;
use Google\Cloud\Dev\DocFx\Node\XrefTrait;
use Google\Cloud\Dev\DocFx\Node\FencedCodeBlockTrait;
use SimpleXMLElement;

/**
 * @group dev
 */
class NodeTest extends TestCase
{
    public function testNestedParameters()
    {
        $nestedParamsXml = file_get_contents(__DIR__ . '/../../fixtures/phpdoc/nestedparams.xml');
        $method = new MethodNode(new SimpleXMLElement($nestedParamsXml));

        $params = $method->getParameters();

        // Assert the parameters have been parsed
        $this->assertCount(8, $params);

        // Assert parent option parameter
        $this->assertEquals('data', $params[1]->getName());
        $this->assertEquals('array', $params[1]->getType());
        $this->assertEquals(
            'Optional. Data for populating the Message object.',
            $params[1]->getDescription()
        );

        // Assert nested parameter
        $this->assertEquals('↳ total_pages', $params[4]->getName());
        $this->assertEquals('int', $params[4]->getType());
        $this->assertEquals(
            'This field gives the total number of pages in the file.',
            $params[4]->getDescription()
        );

        // Assert nested parameter with whitespace
        $this->assertEquals('↳ imageContext', $params[6]->getName());
        $this->assertEquals('ImageContext', $params[6]->getType());
        $this->assertEquals(
            'Additional context that may accompany the image.',
            $params[6]->getDescription()
        );

        // Assert nested parameter with special characters
        $this->assertEquals('↳ exampleString', $params[7]->getName());
        $this->assertEquals('string', $params[7]->getType());
        $this->assertEquals(
            'Ensure special chars are decoded, such as alice@example.com.',
            $params[7]->getDescription()
        );
    }

    public function testProtoRefInParameters()
    {
        $nestedParamsXml = file_get_contents(__DIR__ . '/../../fixtures/phpdoc/nestedparams.xml');
        $method = new MethodNode(new SimpleXMLElement($nestedParamsXml));

        $params = $method->getParameters();

        // Assert proto ref
        $this->assertStringContainsString(
            '<xref uid="\Google\Cloud\Vision\V1\AnnotateImageResponse::getImage()">images</xref>',
            $params[0]->getDescription()
        );

        // Assert proto ref in nested param
        $this->assertStringContainsString(
            '<xref uid="\Google\Cloud\Vision\V1\Image">Image</xref>',
            $params[3]->getDescription()
        );
    }

    public function testProtoPackage()
    {
        $serviceXml = file_get_contents(__DIR__ . '/../../fixtures/phpdoc/service.xml');
        $class = new ClassNode(new SimpleXMLElement($serviceXml));

        $this->assertTrue($class->isServiceClass());
        $this->assertEquals('google.cloud.vision.v1', $class->getProtoPackage());
    }

    public function testSeeTagsInMethodDescription()
    {
        $serviceXml = <<<EOF
<method>
<docblock>
    <description></description>
    <long-description></long-description>
    <tag name="see"
         description="Cool External Resource"
         link="https://wwww.testlink.com"/>
    <tag name="see"
         description=""
         link="\Google\Cloud\Vision\V1\ImageAnnotatorClient"/>
    <tag name="see"
         description="Resume Operation method"
         link="\Google\Cloud\Vision\V1\ImageAnnotatorClient::resumeOperation()"/>
</docblock>
</method>
EOF;
        $method = new MethodNode(new SimpleXMLElement($serviceXml));

        $content = $method->getContent();
        $this->assertStringContainsString(
            'See also:' . "\n" .
            ' - <a href="https://wwww.testlink.com">Cool External Resource</a>' . "\n" .
            ' - <xref uid="\Google\Cloud\Vision\V1\ImageAnnotatorClient">\Google\Cloud\Vision\V1\ImageAnnotatorClient</xref>' . "\n" .
            ' - <xref uid="\Google\Cloud\Vision\V1\ImageAnnotatorClient::resumeOperation()">Resume Operation method</xref>',
            $content
        );
    }

    /**
     * @dataProvider provideReplaceProtoRefWithXref
     */
    public function testReplaceProtoRefWithXref(string $description, string $expected)
    {
        $xref = new class {
            use XrefTrait;
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
                // service method reference
                '[projects.locations.endpoints.predict][google.cloud.aiplatform.v1.PredictionService.Predict]',
                '<xref uid="\Google\Cloud\Aiplatform\V1\PredictionServiceClient::predict()">projects.locations.endpoints.predict</xref>',
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
                '<xref uid="\Google\Bigtable\Admin\V2\BigtableTableAdminClient::listBackups()">ListBackups</xref>'
            ],
            [
                // Enum constants
                '[google.some.Code.INVALID_ARGUMENT][google.some.Code.INVALID_ARGUMENT]',
                '<xref uid="\Google\Some\Code::INVALID_ARGUMENT">google.some.Code.INVALID_ARGUMENT</xref>'
            ],
            [
                // Numbers in the class name
                'Output only. The service account that will be used by the Log Router to access your Cloud KMS key. Before enabling CMEK for Log Router, you must first assign the cloudkms.cryptoKeyEncrypterDecrypter role to the service account that the Log Router will use to access your Cloud KMS key. Use [GetCmekSettings][google.logging.v2.ConfigServiceV2.GetCmekSettings] to obtain the service account ID. See [Enabling CMEK for Log Router](https://cloud.google.com/logging/docs/routing/managed-encryption) for more information.',
                'Output only. The service account that will be used by the Log Router to access your Cloud KMS key. Before enabling CMEK for Log Router, you must first assign the cloudkms.cryptoKeyEncrypterDecrypter role to the service account that the Log Router will use to access your Cloud KMS key. Use <xref uid="\Google\Logging\V2\ConfigServiceV2Client::getCmekSettings()">GetCmekSettings</xref> to obtain the service account ID. See [Enabling CMEK for Log Router](https://cloud.google.com/logging/docs/routing/managed-encryption) for more information.'
            ],
            [
                // Separation between links using newlines
                'Required. The [Model\'s][google.cloud.aiplatform.v1.BatchPredictionJob.model]' . PHP_EOL
                . '[PredictSchemata\'s][google.cloud.aiplatform.v1.Model.predict_schemata]' . PHP_EOL
                . '[instance_schema_uri][google.cloud.aiplatform.v1.PredictSchemata.instance_schema_uri].',
                'Required. The <xref uid="\Google\Cloud\Aiplatform\V1\BatchPredictionJob::getModel()">Model\'s</xref>' . PHP_EOL
                . '<xref uid="\Google\Cloud\Aiplatform\V1\Model::getPredictSchemata()">PredictSchemata\'s</xref>' . PHP_EOL
                . '<xref uid="\Google\Cloud\Aiplatform\V1\PredictSchemata::getInstanceSchemaUri()">instance_schema_uri</xref>.'
            ],
            [
                // Separation within links using newlines
                'Required. The [Model\'s]' . PHP_EOL . '[google.cloud.aiplatform.v1.BatchPredictionJob.model]'
                . ' [PredictSchemata\'s]' . PHP_EOL . '[google.cloud.aiplatform.v1.Model.predict_schemata]'
                . ' [instance_schema_uri]' . PHP_EOL . '[google.cloud.aiplatform.v1.PredictSchemata.instance_schema_uri].',
                'Required. The <xref uid="\Google\Cloud\Aiplatform\V1\BatchPredictionJob::getModel()">Model\'s</xref>'
                . ' <xref uid="\Google\Cloud\Aiplatform\V1\Model::getPredictSchemata()">PredictSchemata\'s</xref>'
                . ' <xref uid="\Google\Cloud\Aiplatform\V1\PredictSchemata::getInstanceSchemaUri()">instance_schema_uri</xref>.'
            ],
            [
                // Separation within links using a space - some APIs do this :/
                'Required. The [Model\'s] [google.cloud.aiplatform.v1.BatchPredictionJob.model]'
                . ' [PredictSchemata\'s] [google.cloud.aiplatform.v1.Model.predict_schemata]'
                . ' [instance_schema_uri] [google.cloud.aiplatform.v1.PredictSchemata.instance_schema_uri].',
                'Required. The <xref uid="\Google\Cloud\Aiplatform\V1\BatchPredictionJob::getModel()">Model\'s</xref>'
                . ' <xref uid="\Google\Cloud\Aiplatform\V1\Model::getPredictSchemata()">PredictSchemata\'s</xref>'
                . ' <xref uid="\Google\Cloud\Aiplatform\V1\PredictSchemata::getInstanceSchemaUri()">instance_schema_uri</xref>.'
            ],
            [
                'Testing that a code sample like $foo["bar"]["baz"] does not get replaced',
                'Testing that a code sample like $foo["bar"]["baz"] does not get replaced'
            ],
        ];
    }

    public function testProtoRefWithXrefUsingPackageName()
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
            '<xref uid="\Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient::listBackups()">ListBackups</xref>',
            $xref->replace($description)
        );

        $classNode = new ClassNode(new SimpleXMLElement(sprintf(
            '<class><docblock><description>%s</description></docblock></class>',
            $description
        )));

        $classNode->setProtoPackages($protoPackages);

        $this->assertEquals(
            '<xref uid="\Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient::listBackups()">ListBackups</xref>',
            $classNode->getContent()
        );
    }

    public function testAddingPhpLanguageHintToFencedCodeBlock()
    {
        $fencedCodeBlock = new class {
            use FencedCodeBlockTrait;

            public function replace(string $description) {
                return $this->addPhpLanguageHintToFencedCodeblock($description);
            }
        };

        $description = <<<EOF
This is a test fenced codeblock

```
use Some\TestFoo;
\$n = new TestFoo();
```

And now you know how to use it!
EOF;

        $expected = <<<EOF
This is a test fenced codeblock

```php
use Some\TestFoo;
\$n = new TestFoo();
```

And now you know how to use it!
EOF;

        $this->assertEquals(
            $expected,
            $fencedCodeBlock->replace($description)
        );

        $descriptionWithIndent = <<<EOF
This is an indented test fenced codeblock

    ```
    use Some\TestFoo;
    \$n = new TestFoo();
    ```

And now you know how to use it!
EOF;

        // Ensure the whitespace indentation works as expected
        $this->assertStringContainsString(
            "\n    ```php\n",
            $fencedCodeBlock->replace($descriptionWithIndent)
        );
        $this->assertStringContainsString(
            "\n    ```\n",
            $fencedCodeBlock->replace($descriptionWithIndent)
        );

        $descriptionWithMultipleCodeblocks = <<<EOF
This is a test fenced codeblock

```
// first codeblock
use Some\TestFoo;
\$n = new TestFoo();
```

```
// second codeblock
use Some\TestFoo;
\$n = new TestFoo();
```
EOF;

        $expected = <<<EOF
This is a test fenced codeblock

```php
// first codeblock
use Some\TestFoo;
\$n = new TestFoo();
```

```php
// second codeblock
use Some\TestFoo;
\$n = new TestFoo();
```
EOF;
        // Ensure the "php" language hint is added to both fenced code blocks.
        $this->assertEquals(
            $expected,
            $fencedCodeBlock->replace($descriptionWithMultipleCodeblocks)
        );

        $descriptionWithDifferentLanguageHint = <<<EOF
This is a test fenced codeblock

```sh
pecl install grpc
```

```
use Some\TestFoo;
\$n = new TestFoo();
```
EOF;

        $expected = <<<EOF
This is a test fenced codeblock

```sh
pecl install grpc
```

```php
use Some\TestFoo;
\$n = new TestFoo();
```
EOF;

        // Ensure the "php" language hint is added only to the second fenced code block.
        $this->assertEquals(
            $expected,
            $fencedCodeBlock->replace($descriptionWithDifferentLanguageHint)
        );
    }

    /**
     * @dataProvider provideStatusAndVersionByNamespace
     */
    public function testStatusAndVersionByNamespace(
        string $namespace,
        string $version,
        bool $isBeta = false
    ) {
        $serviceXml = str_replace(
            '\Google\Cloud\Vision\V1',
            '\Google\Cloud\Vision\\' . $namespace,
            file_get_contents(__DIR__ . '/../../fixtures/phpdoc/service.xml')
        );
        $class = new ClassNode(new SimpleXMLElement($serviceXml));

        $this->assertTrue($class->isServiceClass());
        $this->assertEquals($version, $class->getVersion());
        $this->assertEquals($isBeta, $class->getStatus() === 'beta');
    }

    public function provideStatusAndVersionByNamespace()
    {
        return [
            ['V1alpha', 'V1alpha', true],
            ['V1beta', 'V1beta', true],
            ['V1alpha1', 'V1alpha1', true],
            ['V1beta1', 'V1beta1', true],
            ['V1p1alpha1', 'V1p1alpha1', true],
            ['V1p1beta1', 'V1p1beta1', true],
            ['V2p2beta2', 'V2p2beta2', true],
            ['V1beta1\Foo', 'V1beta1', true],
            ['V1beta\Foo', 'V1beta', true],
            ['V1betaFoo', ''],
            ['V1', 'V1'],
            ['V1\Foo', 'V1'],
            ['V1p1zeta1', ''],
            ['V1z1beta', ''],
            ['Foo', ''],
        ];
    }
}
