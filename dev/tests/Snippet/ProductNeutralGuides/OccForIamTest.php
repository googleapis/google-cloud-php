<?php
/**
 * Copyright 2025 Google Inc.
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

namespace Google\Cloud\Dev\Tests\Snippet;

use Google\Cloud\Core\Exception\FailedPreconditionException;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\Binding;
use Google\Cloud\ResourceManager\V3\Client\ProjectsClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group docs
 */
class OccForIamTest extends SnippetTestCase
{
    private const OCC_FOR_IAM_FILE = __DIR__ . '/../../../../OCC_FOR_IAM.md';
    use ProphecyTrait;

    private string $projectId = 'my-project-id';
    private string $role = 'my-role';
    private string $member = 'my-member';

    /**
     * @runInSeparateProcess
     */
    public function testOccForIam()
    {
        $snippet = $this->snippetFromMarkdown(
            self::OCC_FOR_IAM_FILE,
            'Example'
        );
        // Use the global $projectsClient so we can inject our own
        $snippet->replace('$projectsClient = new ProjectsClient();', 'global $projectsClient;');
        $snippet->invoke();
        $this->assertTrue(function_exists('update_iam_policy_with_occ'));

        $client = $this->prophesize(ProjectsClient::class);

        $request1 = new GetIamPolicyRequest();
        $request1->setResource('projects/' . $this->projectId);
        $policy1 = new Policy();
        $client->getIamPolicy($request1)->shouldBeCalledOnce()->willReturn($policy1);

        $request2 = new SetIamPolicyRequest();
        $request2->setResource('projects/' . $this->projectId);
        $policy2 = new Policy();
        $policy2->setBindings([new Binding(['role' => $this->role, 'members' => [$this->member]])]);
        $request2->setPolicy($policy2);
        $client->setIamPolicy($request2)->shouldBeCalledOnce()->willReturn($policy2);

        global $projectsClient;
        $projectsClient = $client->reveal();

        ob_start();
        $policy = update_iam_policy_with_occ($this->projectId, $this->role, $this->member);
        $output = ob_get_clean();

        $this->assertInstanceOf(Policy::class, $policy);
        $this->assertEquals(<<<EOF
Attempt 0: Reading current IAM policy for projects/my-project-id...
Attempt 0: Setting modified IAM policy...
Successfully updated IAM policy in attempt 0.

EOF, $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testOccForIamMaxRetriesFailsToUpdate()
    {
        $snippet = $this->snippetFromMarkdown(
            self::OCC_FOR_IAM_FILE,
            'Example'
        );

        // Use the global $projectsClient so we can inject our own
        $snippet->replace('$projectsClient = new ProjectsClient();', 'global $projectsClient;');
        $snippet->invoke();
        $this->assertTrue(function_exists('update_iam_policy_with_occ'));

        // Mock the global $projectsClient
        $client = $this->prophesize(ProjectsClient::class);

        $request1 = new GetIamPolicyRequest();
        $request1->setResource('projects/' . $this->projectId);
        $policy1 = new Policy();
        $client->getIamPolicy($request1)->shouldBeCalledOnce()->willReturn($policy1);

        $request2 = new SetIamPolicyRequest();
        $request2->setResource('projects/' . $this->projectId);
        $policy2 = new Policy();
        $policy2->setBindings([new Binding(['role' => $this->role, 'members' => [$this->member]])]);
        $request2->setPolicy($policy2);
        $client->setIamPolicy($request2)
            ->shouldBeCalledOnce()
            ->willThrow(new FailedPreconditionException());

        global $projectsClient;
        $projectsClient = $client->reveal();

        ob_start();
        $policy = update_iam_policy_with_occ($this->projectId, $this->role, $this->member, 1);
        $output = ob_get_clean();

        $this->assertNull($policy);
        $this->assertEquals(<<<EOF
Attempt 0: Reading current IAM policy for projects/my-project-id...
Attempt 0: Setting modified IAM policy...
Concurrency conflict detected (etag mismatch). Retrying... (1/1)
Failed to update IAM policy after 1 attempts due to persistent concurrency conflicts.

EOF, $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testOccForIamMaxRetriesExceeded()
    {
        $snippet = $this->snippetFromMarkdown(
            self::OCC_FOR_IAM_FILE,
            'Example'
        );

        $snippet->invoke();
        $this->assertTrue(function_exists('update_iam_policy_with_occ'));

        ob_start();
        $policy = update_iam_policy_with_occ($this->projectId, $this->role, $this->member, 0);
        $output = ob_get_clean();

        $this->assertNull($policy);
        $this->assertEquals(
            "Failed to update IAM policy after 0 attempts due to persistent concurrency conflicts.\n",
            $output
        );
    }
}
