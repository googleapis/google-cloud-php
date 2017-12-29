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

namespace Google\Cloud\Tests\Snippets\Debugger;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Debugger\Variable;
use Google\Cloud\Debugger\VariableTable;

/**
 * @group debugger
 */
class VariableTableTest extends SnippetTestCase
{
    public function testClass()
    {
        $snippet = $this->snippetFromClass(VariableTable::class);
        $res = $snippet->invoke('variableTable');
        $this->assertInstanceOf(VariableTable::class, $res->returnVal());
    }

    public function testRegister()
    {
        $variableTable = new VariableTable();
        $variable = new Variable('myVar', 'string');
        $snippet = $this->snippetFromMethod(VariableTable::class, 'register');
        $snippet->addLocal('variableTable', $variableTable);
        $snippet->addLocal('variable', $variable);
        $res = $snippet->invoke('variableReference');
        $this->assertInstanceOf(Variable::class, $res->returnVal());
    }

    public function testVariables()
    {
        $variableTable = new VariableTable([new Variable('myVar', 'string')]);
        $snippet = $this->snippetFromMethod(VariableTable::class, 'variables');
        $snippet->addLocal('variableTable', $variableTable);
        $res = $snippet->invoke('variables');
        $variables = $res->returnVal();
        $this->assertCount(1, $variables);
        foreach ($variables as $var) {
            $this->assertInstanceOf(Variable::class, $var);
        }
    }
}
