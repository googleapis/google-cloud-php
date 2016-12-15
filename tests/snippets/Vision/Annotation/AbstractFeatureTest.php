<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Snippets\Vision\Annotation;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Vision\Annotation\AbstractFeature;

/**
 * @group vision
 */
class AbstractFeatureTest extends SnippetTestCase
{
    public function testInfo()
    {
        $stub = new AbstractFeatureImplementation;
        $stub->setInfo('hello world');

        $snippet = $this->snippetFromMethod(AbstractFeature::class, 'info');
        $snippet->addLocal('imageProperties', $stub);

        $res = $snippet->invoke('info');
        $this->assertEquals('hello world', $res->returnVal());
    }
}

class AbstractFeatureImplementation extends AbstractFeature
{
    public function setInfo($info) { $this->info = $info; }
}
