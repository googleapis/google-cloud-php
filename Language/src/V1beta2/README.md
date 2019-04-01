# Cloud Natural Language V1beta2 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Language\V1beta2\AnnotateTextRequest\Features;
use Google\Cloud\Language\V1beta2\Document;
use Google\Cloud\Language\V1beta2\Document\Type;
use Google\Cloud\Language\V1beta2\Entity\Type as EntityType;
use Google\Cloud\Language\V1beta2\LanguageServiceClient;
use Google\Cloud\Language\V1beta2\PartOfSpeech\Tag;

$client = new LanguageServiceClient([
    'credentials' => '/Users/dsupplee/Downloads/gcloud.json'
]);

$document = new Document([
    'content' => 'Greetings from Michigan!',
    'type' => Type::PLAIN_TEXT
]);
$features = new Features([
    'extract_document_sentiment' => true,
    'extract_entities' => true,
    'extract_syntax' => true
]);

// Annotate the document.
$response = $client->annotateText($document, $features);

// Check the sentiment.
$sentimentScore = $response->getDocumentSentiment()
    ->getScore();

if ($sentimentScore > 0) {
    echo 'This is a positive message.' . PHP_EOL;
}

// Detect entities.
foreach ($response->getEntities() as $entity) {
    printf(
        '[%s] %s',
        EntityType::name($entity->getType()),
        $entity->getName()
    );
    echo PHP_EOL;
}

// Parse the syntax.
foreach ($response->getTokens() as $token) {
    $speechTag = Tag::name($token->getPartOfSpeech()->getTag());

    printf(
        '[%s] %s',
        $speechTag,
        $token->getText()->getContent()
    );
    echo PHP_EOL;
}
```
