<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Debugger\Connection;

use Google\Cloud\Core\ArrayTrait;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

/**
 * Implementation of the Firebase connection
 *
 * @internal
 */
class Firebase implements ConnectionInterface
{
    use ArrayTrait;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var array
     */
    private $breakpoints;

    public function __construct(array $config = [])
    {
        if (!class_exists(Factory::class)) {
            throw new \LogicException('Please install "kreait/firebase-php:^5.26.5');
        }
        $databaseUrl = isset($config['firebase_db_url'])
            ? $config['firebase_db_url']
            : null;

        if ($databaseUrl === null) {
            $databaseUrl = 'https://' . $config['projectId'] . '-cdbg.firebaseio.com';
        }

        $this->factory = (new Factory())
            ->withDatabaseUri($databaseUrl);

        if (isset($config['keyFilePath'])) {
            $this->factory = $this->factory->withServiceAccount($config['keyFilePath']);
        }

        $this->database = $this->factory->createDatabase();
        $this->breakpoints = [];
    }

    /**
     * List all registered debuggees.
     *
     * @param array $args {
     *     @type string $project The project ID
     * }
     */
    public function listDebuggees(array $args = [])
    {
        $reference = $this->database->getReference('cdbg/debuggees');
        $debuggees = $reference->getValue();
        return $debuggees;
    }

    /**
     * Register this process as a debuggee.
     *
     * @param array $args
     */
    public function registerDebuggee(array $args = [])
    {
        $debuggeeId = isset($args['debuggee']['id'])
            ? $args['debuggee']['id']
            : $this->generateDebuggeeId($args['debuggee']);

        $args['debuggee']['id'] = $debuggeeId;

        $reference = $this->database->getReference('cdbg/debuggees/' . $debuggeeId);

        $existingDebuggee = $args['debuggee'];

        $debuggee = $this->pluckArray([
            'id',
            'agentVersion',
            'description',
            'project',
            'uniquifier',
        ], $args['debuggee']);
        $descriptionData = explode(':', $debuggee['description']);
        $debuggee['labels']['module'] = $descriptionData[0];
        $debuggee['labels']['version'] = $descriptionData[1];
        $debuggee['registrationTimeUnixMsec'] = $debuggee['lastUpdateTimeUnixMsec'] = round(microtime(true)*1000);
        $reference->set($debuggee);
        $args['debuggee']=$existingDebuggee;
        return $args;
    }

    /**
     * List the breakpoints set for the specified debuggee.
     *
     * @param array $args
     */
    public function listBreakpoints(array $args = [])
    {
        if (!isset($args['waitToken']) || time() > $args['waitToken']) {
            $debuggeeId = $args['debuggeeId'];
            $reference = $this->database->getReference('cdbg/breakpoints/' . $debuggeeId . '/active');
            $this->breakpoints = $reference->getValue();
            $waitToken = time() + 60;
        } else {
            $waitToken = $args['waitToken'];
        }
        $return = [
            'nextWaitToken' => $waitToken
        ];
        if ($this->breakpoints) {
            $return['breakpoints'] = $this->breakpoints;
        }
        return $return;
    }

    /**
     * Update the provided breakpoint.
     *
     * @param array $args
     */
    public function updateBreakpoint(array $args)
    {
        $breakpoint = $args['breakpoint'];
        $breakpointId = $breakpoint['id'];
        $debuggeeId = $args['debuggeeId'];
        // we remove the breakpoint from the active list
        $reference = $this->database->getReference('cdbg/breakpoints/' . $debuggeeId . '/active/' . $breakpointId);
        $reference->remove();
        $breakpoint['finalTimeUnixMsec'] = round(microtime(true)*1000);
        // then we add it to the snapshot list
        $reference = $this->database->getReference('cdbg/breakpoints/' . $debuggeeId . '/snapshot/' . $breakpointId);
        $reference->set($breakpoint);
        // and then to the final list removing those elements that we don't want to save in this list
        if (isset($breakpoint['stackFrames'])) {
            unset($breakpoint['stackFrames']);
        }
        if (isset($breakpoint['variableTable'])) {
            unset($breakpoint['variableTable']);
        }
        if (isset($breakpoint['evaluatedExpressions'])) {
            unset($breakpoint['evaluatedExpressions']);
        }
        $reference = $this->database->getReference('cdbg/breakpoints/' . $debuggeeId . '/final/' . $breakpointId);
        $reference->set($breakpoint);
    }

    /**
     * Sets a breakpoint.
     *
     * @param array $args {
     *     @type string $debuggeeId The Debuggee ID
     *     @type array $location The source location
     * }
     * @return array
     */
    public function setBreakpoint(array $args)
    {
        $breakpoint = $this->pluckArray([
            'action',
            'condition',
            'expressions',
            'logMessageFormat',
            'logLevel',
            'location'
        ], $args);

        $breakpointId = $this->generateBreakpointId($breakpoint);
        $breakpoint['id'] = $breakpointId;
        $debuggeeId = $args['debuggeeId'];
        $reference = $this->database->getReference('cdbg/debuggees/' . $debuggeeId . '/active/' . $breakpointId);
        $reference->set($breakpoint);
        return $breakpoint;
    }

    private function generateDebuggeeId($debuggee)
    {
        return 'd-' . substr(md5(json_encode($debuggee)), 0, 8);
    }

    private function generateBreakpointId($breakpoint)
    {
        return 'b-' . substr(md5(json_encode($breakpoint)), 0, 8);
    }
}
