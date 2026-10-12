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

### Filter Option change

The `rowFilter` option for `Table::readRows` is now called `filter`:

```php
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\V2\RowFilter;

// Only retrieve the most recent version of the cell.
$rowFilter = (new RowFilter())->setCellsPerColumnLimitFilter(1);

$bigtable = new BigtableClient(['projectId' => $projectId]);
$table = $bigtable->table($instanceId, $tableId);

$row = $table->readRow($key, [
    'filter' => $rowFilter
]);
```

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
- `Google\Cloud\Bigtable\V2\Gapic\BigtableGapicClient`, use `Google\Cloud\Bigtable\V2\Client\BigtableClient` instead.
- `Google\Cloud\Bigtable\V2\BigtableClient`, use `Google\Cloud\Bigtable\V2\Client\BigtableClient` instead.
- `Google\Cloud\Bigtable\Admin\V2\Gapic\BigtableInstanceAdminGapicClient`, use `Google\Cloud\Bigtable\Admin\V2\Client\BigtableInstanceAdminClient` instead.
- `Google\Cloud\Bigtable\Admin\V2\Gapic\BigtableTableAdminGapicClient`, use `Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient` instead.
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
- `Google\Cloud\Bigtable\Admin\V2\AppProfile_MultiClusterRoutingUseAny`, use `Google\Cloud\Bigtable\Admin\V2\AppProfile\MultiClusterRoutingUseAny` instead.
- `Google\Cloud\Bigtable\Admin\V2\AppProfile_SingleClusterRouting`, use `Google\Cloud\Bigtable\Admin\V2\AppProfile\SingleClusterRouting` instead.
- `Google\Cloud\Bigtable\Admin\V2\Backup_State`, use `Google\Cloud\Bigtable\Admin\V2\Backup\State` instead.
- `Google\Cloud\Bigtable\Admin\V2\Cluster_ClusterAutoscalingConfig`, use `Google\Cloud\Bigtable\Admin\V2\Cluster\ClusterAutoscalingConfig` instead.
- `Google\Cloud\Bigtable\Admin\V2\Cluster_ClusterConfig`, use `Google\Cloud\Bigtable\Admin\V2\Cluster\ClusterConfig` instead.
- `Google\Cloud\Bigtable\Admin\V2\Cluster_EncryptionConfig`, use `Google\Cloud\Bigtable\Admin\V2\Cluster\EncryptionConfig` instead.
- `Google\Cloud\Bigtable\Admin\V2\Cluster_State`, use `Google\Cloud\Bigtable\Admin\V2\Cluster\State` instead.
- `Google\Cloud\Bigtable\Admin\V2\CreateClusterMetadata_TableProgress`, use `Google\Cloud\Bigtable\Admin\V2\CreateClusterMetadata\TableProgress` instead.
- `Google\Cloud\Bigtable\Admin\V2\CreateClusterMetadata_TableProgress_State`, use `Google\Cloud\Bigtable\Admin\V2\CreateClusterMetadata\TableProgress\State` instead.
- `Google\Cloud\Bigtable\Admin\V2\CreateTableRequest_Split`, use `Google\Cloud\Bigtable\Admin\V2\CreateTableRequest\Split` instead.
- `Google\Cloud\Bigtable\Admin\V2\EncryptionInfo_EncryptionType`, use `Google\Cloud\Bigtable\Admin\V2\EncryptionInfo\EncryptionType` instead.
- `Google\Cloud\Bigtable\Admin\V2\GcRule_Intersection`, use `Google\Cloud\Bigtable\Admin\V2\GcRule\Intersection` instead.
- `Google\Cloud\Bigtable\Admin\V2\GcRule_Union`, use `Google\Cloud\Bigtable\Admin\V2\GcRule\Union` instead.
- `Google\Cloud\Bigtable\Admin\V2\Instance_State`, use `Google\Cloud\Bigtable\Admin\V2\Instance\State` instead.
- `Google\Cloud\Bigtable\Admin\V2\Instance_Type`, use `Google\Cloud\Bigtable\Admin\V2\Instance\Type` instead.
- `Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification`, use `Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest\Modification` instead.
- `Google\Cloud\Bigtable\Admin\V2\Snapshot_State`, use `Google\Cloud\Bigtable\Admin\V2\Snapshot\State` instead.
- `Google\Cloud\Bigtable\Admin\V2\Table_ClusterState`, use `Google\Cloud\Bigtable\Admin\V2\Table\ClusterState` instead.
- `Google\Cloud\Bigtable\Admin\V2\Table_ClusterState_ReplicationState`, use `Google\Cloud\Bigtable\Admin\V2\Table\ClusterState\ReplicationState` instead.
- `Google\Cloud\Bigtable\Admin\V2\Table_TimestampGranularity`, use `Google\Cloud\Bigtable\Admin\V2\Table\TimestampGranularity` instead.
- `Google\Cloud\Bigtable\Admin\V2\Table_View`, use `Google\Cloud\Bigtable\Admin\V2\Table\View` instead.
