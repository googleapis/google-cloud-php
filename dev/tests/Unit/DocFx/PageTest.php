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
use Google\Cloud\Dev\DocFx\Page\Page;
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
        $page = new Page($classNode, '', $packageDescription);

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
}