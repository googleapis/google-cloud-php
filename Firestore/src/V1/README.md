# Cloud Firestore V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Firestore\V1\FirestoreClient;

$firestoreClient = new FirestoreClient();
try {
    $formattedName = $firestoreClient->anyPathName('[PROJECT]', '[DATABASE]', '[DOCUMENT]', '[ANY_PATH]');
    $response = $firestoreClient->getDocument($formattedName);
} finally {
    $firestoreClient->close();
}
```

