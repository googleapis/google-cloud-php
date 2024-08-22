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

use Google\Cloud\Dev\DocFx\Node\ClassNode;
use Google\Cloud\Dev\DocFx\Node\MethodNode;
use Google\Cloud\Dev\DocFx\Node\FencedCodeBlockTrait;
use Google\Cloud\Dev\DocFx\XrefValidationTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Output\OutputInterface;
use SimpleXMLElement;

/**
 * @group dev
 */
class NodeTest extends TestCase
{
    use ProphecyTrait;

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

    public function testProtoRefWithXrefUsingPackageName()
    {
        $description = '[ListBackups][google.bigtable.admin.v2.BigtableTableAdmin.ListBackups]';
        $protoPackages = ['google.bigtable.admin.v2' => 'Google\\Cloud\\Bigtable\\Admin\\V2'];

        $classNode = new ClassNode(new SimpleXMLElement(sprintf(
            '<class><docblock><description>%s</description></docblock></class>',
            $description
        )));

        $classNode->setProtoPackages($protoPackages);

        $this->assertEquals(
            '<xref uid="\Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient::listBackups()">ListBackups</xref>',
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

    /**
     * @dataProvider provideInvalidXrefs
     */
    public function testInvalidXrefs(string $description, array $invalidXrefs = [])
    {
        $classXml = '<class><full_name>TestClass</full_name><docblock><description>%s</description></docblock></class>';
        $class = new ClassNode(new SimpleXMLElement(sprintf($classXml, $description)));

        $validator = new class () {
            use XrefValidationTrait {
                getInvalidXrefs as public;
            }
        };

        $this->assertEquals($invalidXrefs, $validator->getInvalidXrefs($class->getContent()));
    }

    public function provideInvalidXrefs()
    {
        return [
            ['{@see \DoesntExist}'], // class doesn't exist, but is still a valid xref
            ['{@see \SimpleXMLElement::method()}'], // method doesn't exist, but is still a valid xref
            ['{@see \SimpleXMLElement::addAttribute()}'], // valid method
            ['{@see \SimpleXMLElement::OUTPUT_FOO}'],  // constant doesn't exist, but is still a valid xref
            [sprintf('{@see \%s::OUTPUT_NORMAL}', OutputInterface::class)], // valid constant
            ['Take a look at {@see https://foo.bar} for more.'], // valid
            ['{@see Foo\Bar}', ['Foo\Bar']], // invalid
            ['Take a look at {@see Foo\Bar} for more.', ['Foo\Bar']], // invalid
            [
                '{@see \Google\Cloud\PubSub\Google\Cloud\PubSub\Foo}',
                ['\Google\Cloud\PubSub\Google\Cloud\PubSub\Foo']
            ], // invalid
        ];
    }

    /**
     * @dataProvider provideBrokenXrefs
     */
    public function testBrokenXrefs(string $description, string $brokenXref = null)
    {
        $classXml = '<class><full_name>TestClass</full_name><docblock><description>%s</description></docblock></class>';
        $class = new ClassNode(new SimpleXMLElement(sprintf($classXml, $description)));

        $validator = new class () {
            use XrefValidationTrait {
                getBrokenXrefs as public;
            }
        };

        $brokenXrefs = $validator->getBrokenXrefs($class->getContent());
        list($xref, $text) = count($brokenXrefs) ? $brokenXrefs[0] : [null, null];

        $this->assertEquals($brokenXref, $xref);
    }

    public function provideBrokenXrefs()
    {
        return [
            ['{@see \OutputInterface}', '\OutputInterface'], // invalid class (doesn't exist)
            ['{@see \SimpleXMLElement}.'], // valid class
            ['{@see \SimpleXMLElement::method()}', '\SimpleXMLElement::method()'], // invalid method (doesn't exist)
            ['{@see \SimpleXMLElement::addAttribute()}'], // valid method
            ['{@see \SimpleXMLElement::OUTPUT_FOO}', '\SimpleXMLElement::OUTPUT_FOO'],  // invalid constant (doesn't exist)
            [sprintf('{@see \%s::OUTPUT_NORMAL}', OutputInterface::class)], // valid constant
        ];
    }
}
