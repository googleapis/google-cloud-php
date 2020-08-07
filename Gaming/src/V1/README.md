# Google Cloud Game Servers V1 generated client for PHP

### Sample

```php
use Google\Cloud\Gaming\V1\GameServerDeploymentsServiceClient;

$client = new GameServerDeploymentsServiceClient();

$deployments = $client->listGameServerDeployments(
    GameServerDeploymentsServiceClient::locationName('[PROJECT_ID]', 'global')
);

foreach ($deployments as $deployment) {
    print $deployment->getName() . ': ' . $deployment->getDescription() . PHP_EOL;
}
```
