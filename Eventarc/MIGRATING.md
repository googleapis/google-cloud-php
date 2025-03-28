# Migrating Google Cloud Clients to the New Surface

**Document Summary**

 * Google Cloud PHP Client Libraries are releasing new major versions (v2) to
   introduce new surface changes.
 * The PHP Team at Google has developed a tool to automatically upgrade clients
   (see [`ClientUpgradeFixer`][client_upgrade_fixer]).

## WHAT are the new Cloud Clients?

The new Cloud Clients are in the namespace `\Client\`, whereas the previous
clients are one directory above with the same name. For example:

```php
// This is the "new" client
use Google\Cloud\Eventarc\V1\Client\EventarcClient;

// This is the deprecated client (marked with @deprecated)
use Google\Cloud\Eventarc\V1\EventarcClient;
```

The main difference is that RPC methods which used to take a varying number of
required arguments plus an array of optional arguments, now only take a
_single_ `Request` object:

```php
// Create a client.
$eventarcClient = new EventarcClient();

// Prepare the request message.
$request = new GetLocationRequest();

// Call the API and handle any network failures.
try {
    /** @var Location $response */
    $response = $eventarcClient->getLocation($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### RPCs use CallOptions

The new surface RPC methods take an optional array of
[CallOptions][call_options] as the second argument. These are similar to how
the `$optionalArgs` were used in the previous surface, but the new `CallOptions`
_only_ contain options for the call itself, whereas the previous `$optionalArgs`
also held the optional fields for the request body:

```php
// To set call-time options, such as headers, timeouts, and retry options,
// pass them in as the second argument
$callOptions = ['timeoutMillis' => 20];
$response = $eventarcClient->getLocation($request, $callOptions);
```

[call_options]: https://github.com/googleapis/gax-php/blob/main/src/Options/CallOptions.php

### Requests have static `::build` methods

Using Request objects directly can make it more difficult to quickly draft out
the necessary code to deliver an RPC. To mitigate this friction, a static
`::build` method is now generated when one or more
[method signature annotations](https://google.aip.dev/client-libraries/4232)
exist on the RPC.

Any request which has recommended parameters defined in its proto will include a
`::build` method, so that these parameters are easily discoverable:

```php
// Create the RPC request using the static "::build" method
$request = CancelOperationRequest::build($projectId, $zone, $operationId);
$response = $eventarcClient->getLocation($request);
```

## HOW should I upgrade?

The changes are mostly straightforward, and at a minimum require the following:

 - Update Google Cloud clients to use the new client namespace by appending
   `\Client` to the existing namespace.
 - Update RPC calls to accept the corresponding `Request` object.

**NOTE**: Client streaming calls do not require a `Request` object.

### Automatically upgrade code using the `ClientUpgradeFixer` tool

To help migrate code to the new client surface, we've written a
[ClientUpgradeFixer][client_upgrade_fixer] to scan code and upgrade it to match
the new client surface. This tool is not guaranteed to work, so be sure to test
everything that it changes thoroughly. Read more about how to install and run
the tool in its [README][client_upgrade_fixer].

The ClientUpgradeFixer uses [PHP Coding Standards Fixer][cs_fixer] to upgrade
code to use the new client surface:

```bash
# run the CS fixer for that directory using the config above
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.google.php --dry-run --diff /path/to/my/project
```

This will output a diff of the changes. Remove `--dry-run` from the above
command to apply the changes automatically.


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

## Feedback

Your feedback is important to us! Please continue to provide us with any
thoughts and questions in the [Issues][google-cloud-issues] section of this
repository.

[google-cloud-issues]: https://github.com/googleapis/google-cloud-php/issues
