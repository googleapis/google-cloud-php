# Migrating Google Cloud Bigtable from V1 to V2

## How to upgrade

Update your `google/cloud-bigtable` dependency to `^2.0`:

```
{
    "require": {
        "google/cloud-bigtable": "^2.0"
    }
}
```

## Changes

### Retry Options changes

The `retries` parameter in the following RPC calls is changed to `retrySettings.maxRetries`:
- Google\Cloud\Bigtable\Table::mutateRows
- Google\Cloud\Bigtable\Table::upsert
- Google\Cloud\Bigtable\Table::readRows

For example:
```php
$table->readRows([
    'retrySettings' => [
        'maxRetries' => 3
    ]
]);
```

OR

```php
$retrySettings = RetrySettings::constructDefault();
$retrySettings = $retrySettings->with(['maxRetries' => 3])
$table->readRows([
    'retrySettings' => $retrySettings
]);
```

This is done in order to be consistent across other RPC calls which use GAX's retrySettings and to be consistent across other products which mostly use the [RetrySettings](https://github.com/googleapis/gax-php/blob/main/src/RetrySettings.php) from GAX already.

Only the maxRetries parameter is supported for now and not the other options in the `RetrySettings`.

### Removed deprecated classes

The following deprecated classes are now removed completely. Use the specified alternatives.
- `Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry`, use `Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry` instead.
- `Google\Cloud\Bigtable\V2\MutateRowsResponse_Entry`, use `Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry` instead.
- `Google\Cloud\Bigtable\V2\Mutation_DeleteFromFamily`, use `Google\Cloud\Bigtable\V2\Mutation\DeleteFromFamily` instead.
- `Google\Cloud\Bigtable\V2\Mutation_DeleteFromColumn`, use `Google\Cloud\Bigtable\V2\Mutation\DeleteFromColumn` instead.
- `Google\Cloud\Bigtable\V2\Mutation_DeleteFromRow`, use `Google\Cloud\Bigtable\V2\Mutation\DeleteFromRow` instead.
- `Google\Cloud\Bigtable\V2\Mutation_SetCell`, use `Google\Cloud\Bigtable\V2\Mutation\SetCell` instead.
- `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse_CloseStream`, use Google\Cloud\Bigtable\V2\ReadChangeStreamResponse\CloseStream`` instead.
- `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse_DataChange_Type`, use `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse\DataChange\Type` instead.
- `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse_DataChange`, use `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse\DataChange` instead.
- `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse_Heartbeat`, use `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse\Heartbeat` instead.
- `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse_MutationChunk_ChunkInfo`, use `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse\MutationChunk\ChunkInfo` instead.
- `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse_MutationChunk`, use `Google\Cloud\Bigtable\V2\ReadChangeStreamResponse\MutationChunk` instead.
- `Google\Cloud\Bigtable\V2\ReadRowsRequest_RequestStatsView`, use `Google\Cloud\Bigtable\V2\ReadRowsRequest\RequestStatsView` instead.
- `Google\Cloud\Bigtable\V2\RowFilter_Chain`, use `Google\Cloud\Bigtable\V2\RowFilter\Chain` instead.
- `Google\Cloud\Bigtable\V2\RowFilter_Condition`, use `Google\Cloud\Bigtable\V2\RowFilter\Condition` instead.
- `Google\Cloud\Bigtable\V2\RowFilter_Interleave`, use `Google\Cloud\Bigtable\V2\RowFilter\Interleave` instead.
- `Google\Cloud\Bigtable\V2\ReadRowsResponse_CellChunk`, use `Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk` instead.
