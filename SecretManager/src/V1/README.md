# Secret Manager V1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\SecretManager\V1\Replication;
use Google\Cloud\SecretManager\V1\Replication\Automatic;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;

$client = new SecretManagerServiceClient();

$secret = $client->createSecret(
    SecretManagerServiceClient::projectName('[MY_PROJECT_ID]'),
    '[MY_SECRET_ID]',
    [
        'secret' => new Secret([
            'replication' => new Replication([
                'automatic' => new Automatic()
            ])
        ])
    ]
);

printf(
    'Created secret: %s' . PHP_EOL,
    $secret->getName()
);
```
