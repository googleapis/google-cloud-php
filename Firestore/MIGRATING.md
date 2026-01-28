# Migration Guide: v1 to v2

This document outlines the key breaking changes introduced in version 2 of the google-cloud-php Firestore library and provides guidance on how to update your code.

## 1. Removal of the `Connection` Layer

The most significant change in v2 is the removal of the `ConnectionInterface` and its `Grpc` implementation. All classes that previously depended on the connection layer now interact directly with the auto generated client for Firestore (`Google\Cloud\Firestore\V1\Client\FirestoreClient`).

This change simplifies the library's architecture but requires updates to how you instantiate several core classes.

**Note**: If you primarily use factory methods (e.g. `$firestore->collection(...)`, `$collection->document(...)`), your
code likely requires no changes, as the library handles these dependencies internally.

## 2. Constructor Changes

Due to the removal of the `Connection` layer, the constructors for the following classes have changed. They no longer accept a `ConnectionInterface` instance and instead require a `Google\Cloud\Firestore\V1\Client\FirestoreClient` instance.

- `AggregateQuery`
- `BulkWriter`
- `CollectionReference`
- `DocumentReference`
- `FirestoreClient`
- `FirestoreSessionHandler`
- `Query`
- `Transaction`
- `ValueMapper`

**Migration Action:**

When creating instances of these classes, you must now pass a `Google\Cloud\Firestore\V1\Client\FirestoreClient` object instead of a `ConnectionInterface` object.

**Example: `DocumentReference`**

*Before (v1):*
```php
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\CollectionReference;

$docRef = new DocumentReference(
    $connection, // Instance of ConnectionInterface
    $valueMapper,
    $parent,
    $name
);
```

*After (v2):*
```php
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Firestore\CollectionReference;

$docRef = new DocumentReference(
    $firestoreClient, // Instance of FirestoreClient
    $valueMapper,
    $parent,
    $name
);
```

You will need to apply similar changes wherever you instantiate the classes listed above. The main `FirestoreClient` will now manage the GAPIC client instance.

## 3. `WriteBatch` Class Removed

The `WriteBatch` class, which was previously a deprecated alias for `BulkWriter`, has been completely removed.

**Migration Action:**

If you are still using the `WriteBatch` class, you must update your code to use `BulkWriter` directly. The functionality is identical.

*Before (v1):*
```php
$batch = $firestore->batch();
// or
$batch = new WriteBatch(...);
```

*After (v2):*
```php
$batch = $firestore->bulkWriter();
// or
$batch = new BulkWriter(...);
```

## Summary of Key Changes

| Class/Method | v1 Status | v2 Status | Migration Action |
|---|---|---|---|
| `ConnectionInterface` | In Use | **Removed** | Refactor code to use `V1\Client\FirestoreClient`. Update constructor calls for dependent classes. |
| `WriteBatch` | Deprecated | **Removed** | Replace `WriteBatch` with `BulkWriter`. |
| Class Constructors | Accepted `ConnectionInterface` | Accept `V1\Client\FirestoreClient` | Update arguments passed to constructors. |

By addressing these key areas, you can successfully migrate your application to version 2 of the Firestore client library.
