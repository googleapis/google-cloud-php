<?php

#putenv('GOOGLE_APPLICATION_CREDENTIALS=~/.config/gcloud/application_default_credentials.json');
$targetAudience = '$YOUR_AUDIENCE';
$baseUri = '$YOU_IAP_URL';
$url = '$YOUR_IAP_ENDPOINT';

$stack = HandlerStack::create();

$memoryCache = new MemoryCacheItemPool;
$cacheConfig = ['prefix' => 'your_cache_key'];
$middleware = ApplicationDefaultCredentials::getIdTokenMiddleware($targetAudience, null, $cacheConfig, $memoryCache);
$stack->push($middleware);

$options = [
  'handler' => $stack,
  'auth' => 'google_auth',
  'base_uri' => $baseUri,
];
$client = new Client($options);
 
$res = $client->get($url);

// Will throw exception
$res = $client->get($url);
