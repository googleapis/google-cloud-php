# Google Cloud Gke Backup for PHP

> Idiomatic PHP client for [Google Cloud Gke Backup](https://cloud.google.com/kubernetes-engine/docs/add-on/backup-for-gke).

[![Latest Stable Version](https://poser.pugx.org/google/cloud-gke-backup/v/stable)](https://packagist.org/packages/google/cloud-gke-backup) [![Packagist](https://img.shields.io/packagist/dm/google/cloud-gke-backup.svg)](https://packagist.org/packages/google/cloud-gke-backup)

* [API documentation](https://cloud.google.com/php/docs/reference/cloud-gke-backup/latest)

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

### Installation

To begin, install the preferred dependency manager for PHP, [Composer](https://getcomposer.org/).

Now to install just run:

```sh
$ composer require google/cloud-gke-backup
```

This component supports both REST over HTTP/1.1 and gRPC. In order to take advantage of the benefits offered by gRPC (such as streaming methods)
please see our [gRPC installation guide](https://cloud.google.com/php/grpc).

### Authentication

Please see our [Authentication guide](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md) for more information
on authenticating your client. Once authenticated, you'll be ready to start making requests.

### Sample

```php
use Google\ApiCore\ApiException;
use Google\Cloud\GkeBackup\V1\Backup;
use Google\Cloud\GkeBackup\V1\Client\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\GetBackupRequest;

// Create a client.
$backupForGKEClient = new BackupForGKEClient();

// Prepare the request message.
$request = (new GetBackupRequest())
    ->setName($formattedName);

// Call the API and handle any network failures.
try {
    /** @var Backup $response */
    $response = $backupForGKEClient->getBackup($request);
    printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
} catch (ApiException $ex) {
    printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
}
```

### Debugging

Please see our [Debugging guide](https://github.com/googleapis/google-cloud-php/blob/main/DEBUG.md)
for more information about the debugging tools.

### Version

This component is considered GA (generally available). As such, it will not introduce backwards-incompatible changes in
any minor or patch releases. We will address issues and requests with the highest priority.

### Next Steps

1. Understand the [official documentation](https://cloud.google.com/kubernetes-engine/docs/add-on/backup-for-gke).
