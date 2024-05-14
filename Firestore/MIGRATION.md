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

$timestamp = (new Timestamp())
    ->fromDateTime(new \DateTime());
```




