# Optimistic Concurrency Control (OCC) Loop for IAM

Optimistic Concurrency Control (OCC) is a strategy used to manage shared resources and prevent "lost updates" or race conditions when multiple users or processes attempt to modify the same resource simultaneously.

In the context of Google Cloud IAM, the resource is the **IAM Policy** applied to a resource (like a Project, Bucket, or Service). An IAM Policy object contains a version number and an `etag` (entity tag) field.

## Introduction to OCC

Imagine two processes, A and B, try to add a user to a policy at the same time:

1. Process **A** reads the current policy.
2. Process **B** reads the *same* current policy (containing the original list of users).
3. Process **A** adds a new user to its copy of the policy and writes it back to the server.
4. Process **B** adds a *different* new user to its copy of the policy and writes it back to the server.

Because Process **B** overwrites the policy *without* knowing that Process **A** already changed it, the user added by Process **A** is **lost**.

OCC introduces a unique fingerprint which changes every time an entity is modified. In the case of IAM, this is done using an `etag`. The IAM service checks this tag on every write:

1. When you read the policy, the server returns an `etag` (a unique fingerprint).
2. When you send the modified policy back, you must include the original `etag`.
3. If the server finds that the stored `etag` does **not** match the `etag` you sent (meaning someone else modified the policy since you read it), the write operation fails with an `ABORTED` or `FAILED_PRECONDITION` error.

This failure forces the client to **retry** the entire process—re-read the *new* policy, re-apply the changes, and try the write again with the new `etag`.

## Implementing the OCC Loop in PHP

The core of the OCC implementation is a `while` loop that handles the retry logic. You should set a reasonable maximum number of retries to prevent infinite loops in cases of high contention.

### Steps of the Loop:

| Step | Action | PHP Implementation |
| ----- | ----- | ----- |
| **1\. Read** | Fetch the current IAM Policy, including the `etag`. | `$policy = $client->getIamPolicy($resourceName);` |
| **2\. Modify** | Apply the desired changes (e.g., add a binding, change a role) to the local policy object. | `$policy->setBindings($updatedBindings);` |
| **3\. Write/Check** | Attempt to set the modified policy using the old `etag`. This action must be inside a `try` block. | `try {    $client->setIamPolicy($resourceName, $policy);    return $policy; } catch (AbortedException $e) {    // retry loop}` |
| **4\. Success/Retry** | If the write succeeds, exit the loop. If it fails with a concurrency error, increment the retry counter and continue the loop (go back to Step 1). |  |

The following file provides a runnable example of how to implement the OCC loop to add a new member to an IAM policy on a Project resource.

*Note: This example uses the `google/cloud-resource-manager` component, but the same OCC pattern applies to any service that uses IAM policies (Storage, Pub/Sub, etc.).*

```php
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\FailedPreconditionException;
use Google\Cloud\ResourceManager\V3\Client\ProjectsClient;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\Binding;

/**
 * Executes an Optimistic Concurrency Control (OCC) loop to safely update an IAM policy.
 *
 * This function demonstrates the core Read-Modify-Write-Retry pattern.
 *
 * @param string $projectId The Google Cloud Project ID (e.g., 'my-project-123').
 * @param string $role The IAM role to grant (e.g., 'roles/storage.objectAdmin').
 * @param string $member The member to add (e.g., 'user:user@example.com').
 * @param int $maxRetries The maximum number of times to retry the update.
 * @return Policy The successfully updated IAM policy (or null on failure).
 */
function update_iam_policy_with_occ(
    string $projectId,
    string $role,
    string $member,
    int $maxRetries = 5
): ?Policy {
    // 1. Setup Client (Example using ResourceManager - adjust for your service)
    $projectsClient = new ProjectsClient();
    $projectName = ProjectsClient::projectName($projectId);

    $retries = 0;

    // --- START OCC LOOP (Read-Modify-Write-Retry) ---
    while ($retries < $maxRetries) {
        try {
            // 1. READ: Get the current policy. This includes the current etag.
            echo "Attempt $retries: Reading current IAM policy for $projectName...\n";
            $getIamPolicyRequest = new GetIamPolicyRequest(['resource' => $projectName]);
            $policy = $projectsClient->getIamPolicy($getIamPolicyRequest);

            // 2. MODIFY: Apply the desired changes to the local Policy object ($policy).
            $bindings = $policy->getBindings();
            $binding = new Binding(['role' => $role, 'members' => [$member]]);
            foreach ($bindings as $existingBinding) {
                if ($existingBinding->getRole() === $role) {
                    $binding = $existingBinding;
                    foreach ($binding->getMembers() as $roleMember) {
                        if ($roleMember === $member) {
                            echo "Policy for role $role and member $member exists already!\n";
                            return $policy;
                        }
                    }
                    $members = $binding->getMembers();
                    $members[] = $member;
                    $binding->setMembers($members);
                }
            }

            // The policy object now contains the modified bindings AND the original etag.
            $bindings[] = $binding;
            $policy->setBindings($bindings);

            // 3. WRITE/CHECK: Attempt to write the modified policy.
            echo "Attempt $retries: Setting modified IAM policy...\n";
            $setIamPolicyRequest = new SetIamPolicyRequest(['resource' => $projectName, 'policy' => $policy]);
            $newPolicy = $projectsClient->setIamPolicy($setIamPolicyRequest);

            // 4. SUCCESS: If the call succeeds, return the new policy and exit the loop.
            echo "Successfully updated IAM policy in attempt $retries.\n";
            return (object) $policy; // Mock return
        } catch (AbortedException | FailedPreconditionException $e) {
            // If the etag is stale (concurrency conflict), this will throw a retryable exception.
            $retries++;
            echo "Concurrency conflict detected (etag mismatch). Retrying... ($retries/$maxRetries)\n";
            usleep(100000 * $retries); // Exponential backoff (100ms * retry count)
        }
    }
    // --- END OCC LOOP ---

    echo "Failed to update IAM policy after $maxRetries attempts due to persistent concurrency conflicts.\n";
    return null;
}
```

