# Migration Guide for V2 library


## Timestamp

Throughout the exposed functionalities of the library, all the `\Google\Cloud\Core\Timestamp` usage has been replaced with `\Google\Protobuf\Timestamp`.

Earlier usage:

```php
use Google\Cloud\Code\Timestamp;

$timestamp = new Timestamp(new \DateTime());
```

Current usage:

```php
use Google\Protobuf\Timestamp;

$timestamp = new Timestamp();
$timestamp->fromDateTime(new \DateTime());
```
## ListCollectionIds

ListCollectionIds rpc is exposed via `DocumentReference::collections()` and `FirestoreClient::collections()` methods.
These method used to return an `\InvalidArgumentException` when `readTime` was invalid. Now we've removed this client
level check and exception is thrown by the Serializer when it converts the array data into Protobuf Request object.

## ListDocuments

ListDocuments rpc is exposed via [Lorem Epsum] methods. These method used to return an `\InvalidArgumentException`
when `readTime` was invalid. Now we've removed this client level check and exception is thrown by the Serializer
when it converts the array data into Protobuf Request object.



