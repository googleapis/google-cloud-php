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

use Google\Auth\Credentials\AppIdentityCredentials;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\Iam;
use Google\Auth\OAuth2;
use PHPUnit\Framework\TestCase;
use Google\Cloud\Dev\DocFx\Node\ClassNode;
use Google\Cloud\Dev\DocFx\Node\InterfaceNode;
use Google\Cloud\Dev\DocFx\Node\MethodNode;
use Google\Cloud\Dev\DocFx\Page\OverviewPage;
use Google\Cloud\Dev\DocFx\Page\Page;
use Google\Cloud\Dev\DocFx\Page\PageTree;
use SimpleXMLElement;

/**
 * @group dev
 */
class PageTest extends TestCase
{
    /**
     * @dataProvider provideFriendlyApiName
     */
    public function testFriendlyApiName(
        string $namespace,
        string $packageDescription,
        string $expected
    ) {
        $serviceXml = str_replace(
            '\Google\Cloud\Vision\V1',
            $namespace,
            file_get_contents(__DIR__ . '/../../fixtures/phpdoc/service.xml')
        );
        $classNode = new ClassNode(new SimpleXMLElement($serviceXml));
        $componentPath = __DIR__ . '/../../fixtures/component/Vision';
        $page = new Page($classNode, '', $packageDescription, $componentPath);

        $this->assertEquals($expected, $page->getItems()[0]['friendlyApiName']);
    }

    public function provideFriendlyApiName()
    {
        return [
            ['\Google\Cloud\Vision\V1', 'Cloud Vision Client for PHP', 'Cloud Vision V1 Client'],
            ['\Google\Cloud\Vision', 'Cloud Vision Client for PHP', 'Cloud Vision Client'],
            ['\Google\Cloud\Vision\V1', 'Cloud Vision', 'Cloud Vision V1 Client'],
            ['\Google\Cloud\Vision', 'Cloud Vision', 'Cloud Vision Client'],
            ['\Google\Cloud\Vision\V1', 'Cloud Vision Client', 'Cloud Vision V1 Client'],
            ['\Google\Cloud\Vision\Foo', 'Cloud Vision Client', 'Cloud Vision Client'],
            ['\Google\Cloud\Vision\V1beta1', 'Cloud Vision Client for PHP', 'Cloud Vision V1beta1 Client'],
            ['\Google\Cloud\Vision\V1\Foo', 'Cloud Vision Client for PHP', 'Cloud Vision V1 Client'],
        ];
    }

    public function testLoadPagesProtoPackages()
    {
        $structureXml = __DIR__ . '/../../fixtures/phpdoc/vision.xml';
        $componentPath = __DIR__ . '/../../fixtures/component/Vision';
        $protoPackages = [
            'google.longrunning' => 'Google\LongRunning',
            'google.cloud.vision.v1' => 'Google\Cloud\Vision\V1',
        ];
        $pageTree = new PageTree(
            $structureXml,
            'Google\Cloud\Vision',
            '',
            $componentPath,
            $protoPackages
        );

        $pages = $pageTree->getPages();
        $this->assertTrue(count($pages) > 0);
        $classNode = array_pop($pages)->getClassNode();

        $classNodeReflection = new \ReflectionClass($classNode);
        $protoPackagesProperty = $classNodeReflection->getProperty('protoPackages');

        $this->assertEquals(
            $protoPackages,
            $protoPackagesProperty->getValue($classNode)
        );
    }

    public function testOverviewPage()
    {
        $overview1 = new OverviewPage("# Not beta\n\n", $beta = false);
        $this->assertEquals("# Not beta\n\n", $overview1->getContents());

        $overview2 = new OverviewPage("No header\n\n", $beta = true);
        $this->assertEquals("No header\n\n", $overview2->getContents());

        $overview3 = new OverviewPage("# No newline", $beta = true);
        $this->assertEquals('# No newline', $overview3->getContents());

        $overview4 = new OverviewPage("# Yes beta\nend.", $beta = true);
        $this->assertStringContainsString('pre-GA', $overview4->getContents());
        $this->assertStringStartsWith("# Yes beta\n", $overview4->getContents());
        $this->assertStringEndsWith("\nend.", $overview4->getContents());
    }

    public function testInterfacePage()
    {
        $pageTree = new PageTree(
            __DIR__ . '/../../fixtures/phpdoc/auth.xml',
            'Google\Auth',
            'Google Auth',
            __DIR__ . '/../../../vendor/google/auth',
            [],
        );

        $interfacePage = $this->findNode($pageTree->getPages(), FetchAuthTokenInterface::class);;
        $this->assertNotNull($interfacePage);
        $description = $interfacePage->getLongDescription();
        $this->assertStringContainsString(
            ServiceAccountCredentials::class,
            $description
        );
    }

    public function testDeprecatedNodes()
    {
        $pageTree = new PageTree(
            __DIR__ . '/../../fixtures/phpdoc/auth.xml',
            'Google\Auth',
            'Google Auth',
            __DIR__ . '/../../../vendor/google/auth',
            [],
        );

        $deprecatedXml = file_get_contents(__DIR__ . '/../../fixtures/phpdoc/deprecated.xml');
        $deprecatedClass = new ClassNode(new SimpleXMLElement($deprecatedXml), []);
        $this->assertTrue($deprecatedClass->isDeprecated());
        $this->assertEquals('this is now deprecated', $deprecatedClass->getDeprecatedDescription());

        $deprecatedConstant = $this->findNode($pageTree->getPages(), Iam::class, 'IAM_API_ROOT');
        $this->assertNotNull($deprecatedConstant);
        $this->assertTrue($deprecatedConstant->isDeprecated());
        $this->assertEquals('', $deprecatedConstant->getDeprecatedDescription());

        $deprecatedMethod = $this->findNode($pageTree->getPages(), OAuth2::class, 'getCacheKey');
        $this->assertNotNull($deprecatedMethod);
        $this->assertTrue($deprecatedMethod->isDeprecated());
        $this->assertNotEquals('', $deprecatedMethod->getDeprecatedDescription());

        $deprecatedParam = $deprecatedClass->getMethods()[0]->getParameters()[0];
        $this->assertTrue($deprecatedParam->isDeprecated());

        $deprecatedNestedParam = null;
        $nestedParamsXml = file_get_contents(__DIR__ . '/../../fixtures/phpdoc/nestedparams.xml');
        $methodWithDeprecatedParams = new MethodNode(new SimpleXMLElement($nestedParamsXml), '', [], '');
        foreach ($methodWithDeprecatedParams->getParameters() as $nestedParam) {
            if ($nestedParam->getName() === '↳ obsoleteParam') {
                $deprecatedNestedParam = $nestedParam;
            }
        }
        $this->assertNotNull($deprecatedNestedParam);
        $this->assertTrue($deprecatedNestedParam->isDeprecated());
    }

    public function testHandleSample()
    {
        $structureXml = __DIR__ . '/../../fixtures/phpdoc/clientsnippets.xml';
        $componentPath = __DIR__ . '/../../fixtures/component/ClientSnippets';
        $pageTree = new PageTree($structureXml, 'Google\Cloud\ClientSnippets', '', $componentPath, []);

        $pages = $pageTree->getPages();
        $this->assertCount(1, $pages);
        $items = array_pop($pages)->getItems();
        $this->assertCount(2, $items);
        $rpcMethod = $items[1];
        $this->assertArrayHasKey('example', $rpcMethod);
        $this->assertNotEmpty($rpcMethod['example']);
        $this->assertCount(1, $rpcMethod['example']);
        $this->assertStringContainsString('function an_rpc_method_sample', $rpcMethod['example'][0]);
    }

    private function findNode(array $pages, string $className, string $methodOrConstant = '')
    {
        foreach ($pages as $page) {
            if ($page->getClassNode()->getFullname() === '\\' . $className) {
                if (!$methodOrConstant) {
                    return $page->getClassNode();
                }

                foreach ($page->getClassNode()->getMethods() as $method) {
                    if ($method->getFullname() === '\\' . $className . '::' . $methodOrConstant . '()') {
                        return $method;
                    }
                }

                foreach ($page->getClassNode()->getConstants() as $constant) {
                    if ($constant->getFullname() === '\\' . $className . '::' . $methodOrConstant) {
                        return $constant;
                    }
                }
            }
        }
    }
}
