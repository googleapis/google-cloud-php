# Migrating Google Cloud Clients to the New Surface

**Document Summary**

 * Google Cloud PHP Client Libraries are cutting new major versions (v2) to
   introduce new surface changes. This document details all those changes and
   how you can use them in your application.
 * The Google Cloud PHP Team has developed a tool to automate upgrading clients
   in your library. For instructions, see
   the `ClientUpgradeFixer` [README][client_upgrade_fixer].

## WHERE are the new Cloud Clients?

The new cloud clients are a new client in the namespace `\Client\`, whereas the
previous clients are one directory above that with the same name. For example:

```php
// This is the "new" client
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;

// This is the deprecated client (marked with @deprecated)
use Google\Cloud\Tasks\V2\CloudTasksClient;
```

## WHAT is the difference?

The main difference is that RPC methods which used to take misc required
arguments and an array of optional arguments, now will always take a single
argument for the RPC request:

```php
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;
use Google\Cloud\Tasks\V2\CloudTasksClient as DeprecatedCloudTasksClient;

use Google\Cloud\Tasks\V2\CreateTaskRequest;
use Google\Cloud\Tasks\V2\Task;

$parent = CloudTasksClient::queueName('[PROJECT]', '[LOCATION]', '[QUEUE]');
$task = new Task();

// This is the "new" way to make an RPC request
$tasksClient = new CloudTasksClient();
$request = (new CreateTaskRequest())
    ->setParent($parent)
    ->setTask($task)
    ->setResponseView(Task\View::FULL);
$response = $taskClient->createTask($request);

// This is the DEPRECATED way to make the same RPC request
$tasksClient = new DeprecatedCloudTasksClient()
$response = $taskClient->createTask($parent, $task, [
    'responseView' => Task\View::FULL,
]);
```

### RPCs use CallOptions

The RPC methods also take an optional array of [CallOptions][call_options] as
the second argument. These are similar to the `$optionalArgs` in the previous
surface, but _only_ contain options for the call itself, whereas previously
it also held the optional fields of the request body:

```php
// To set call-time options, such as headers, timeouts, and retry options,
// pass them in as the second argument
$callOptions = ['timeoutMillis' => 20];
$response = $taskClient->createTask($request, $callOptions);

// This is the DEPRECATED way to make the same RPC request
$response = $taskClient->createTask($parent, $task, [
    'responseView' => Task\View::FULL,
    'timeoutMillis' => 20,
]);
```

[call_options]: https://github.com/googleapis/gax-php/blob/main/src/Options/CallOptions.php

### Requests have static "build" methods

Using Request objects directly can make it more difficult for users to quickly
draft out the necessary code to deliver an RPC successfully. To mitigate this
friction, a static "build" method is now generated when one or more
[method signature annotations](https://google.aip.dev/client-libraries/4232)
exist on the RPC.

Any request which has recommended parameters defined will include a `build`
method, so that these parameters are easily discoverable:


```php
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;
use Google\Cloud\Tasks\V2\CreateTaskRequest;
use Google\Cloud\Tasks\V2\Task;

$tasksClient = new CloudTasksClient();
$parent = CloudTasksClient::queueName('[PROJECT]', '[LOCATION]', '[QUEUE]');
$task = new Task();

// create the request using the "build" method
$request = CreateTaskRequest::build($parent, $task);
$response = $taskClient->createTask($request);
```

## HOW can I upgrade?

The changes are mostly straightforward, and at a minimum require the following

 - Update your client to use the new client namespace (by appending `\Client`
   to the existing namespace)
 - Update your RPC calls to accept the corresponding
   `Request` object

**NOTE**: Client streaming calls do not require a `Request` object.

### Automatically upgrade your code using our `ClientUpgradeFixer` tool

To help you migrate your code to the new client surface, we've written a
[ClientUpgradeFixer][client_upgrade_fixer] to scan your code and upgrade the
functions to match the new client surface. This tool is not guaranteed to work,
so be sure to test everything that it changes thoroughly. You can read more
about how to install and run the tool in its README.

The ClientUpgradeFixer uses [PHP Coding Standards Fixer][cs_fixer] to upgrade
your code to use the new client surface:

```bash
# run the CS fixer for that directory using the config above
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.google.php --dry-run --diff /path/to/my/project
```

This will output a diff of the changes. Remove `--dry-run` from the above
command to have the changes applied automatically.


```diff
-use Google\Cloud\Dlp\V2\DlpServiceClient;
+use Google\Cloud\Dlp\V2\Client\DlpServiceClient;
+use Google\Cloud\Dlp\V2\CreateDlpJobRequest;
 use Google\Cloud\Dlp\V2\InspectConfig;
 use Google\Cloud\Dlp\V2\InspectJobConfig;
 use Google\Cloud\Dlp\V2\Likelihood;
+use Google\Cloud\Dlp\V2\ListInfoTypesRequest;
 use Google\Cloud\Dlp\V2\StorageConfig;

 // Instantiate a client.
 $dlp = new DlpServiceClient();

 // optional args array (variable)
-$infoTypes = $dlp->listInfoTypes($parent);
+$request = (new ListInfoTypesRequest());
+$infoTypes = $dlp->listInfoTypes($request);

 // optional args array (inline array)
-$job = $dlp->createDlpJob($parent, ['jobId' => 'abc', 'locationId' => 'def']);
+$request2 = (new CreateDlpJobRequest())
+    ->setParent($parent)
+    ->setJobId('abc')
+    ->setLocationId('def');
+$job = $dlp->createDlpJob($request2);
```

[cs_fixer]: https://cs.symfony.com/
[client_upgrade_fixer]: https://github.com/GoogleCloudPlatform/php-tools/blob/main/src/Fixers/ClientUpgradeFixer/README.md
