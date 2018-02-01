<?php
require 'vendor/autoload.php';

use Google\Cloud\Bigtable\src\BigtableTable;

/**
 * A minimal application that connects to Cloud Bigtable using the native HBase API
 * and performs some basic operations.
 */

class HelloWorld
{
	private $tableName    = 'Hello-Bigtable';
	private $columnFamily = 'cf';
	private $rowKey       = 'key';

	/**
	 * Connects to Cloud Bigtable, runs some basic operations and prints the results.
	 */
	public function doHelloWorld($projectId, $instanceId)
	{

		$bigtableTable = new BigtableTable();

		$parent = $bigtableTable->instanceName($projectId, $instanceId);

		$this->print("Create table ".$this->tableName);
		try {
			$bigtableTable->createTableWithColumnFamily($parent, $this->tableName, $this->columnFamily);
		}
		 catch (Exception $e) {
			$this->print("Creating table error ".$e->getMessage());
		}

		//Get created table name
		$formatedTable = $bigtableTable->tableName($projectId, $instanceId, $this->tableName);
		$this->print("Formatted table name ".$formatedTable);
		
		//Inserting Record into table
		$MutationArray = [];
		$cell['cf'] = $this->columnFamily;
		$cell['qualifier'] = 'qualifier';
		$cell['value'] = 'VALUE';

		$utc_str = gmdate("M d Y H:i:s", time());
		$utc     = strtotime($utc_str);
		$cell['timestamp'] = $utc*1000;

		$MutationArray[] = $bigtableTable->mutationCell($cell);

		$this->print("Inserting record into table ".$this->tableName);
		try {
			$bigtableTable->mutateRow($formatedTable, $this->rowKey, $MutationArray);
		}
		 catch (Exception $e) {
			$this->print("Inserting record error ".$e->getMessage());
		}
		
		//Get row from table
		$this->print("Get row from table ".$this->tableName);
		$FlatRow = $bigtableTable->readRows($formatedTable);
		for ($i = 0; $i < count($FlatRow); $i++) {
			$row = $FlatRow[$i];

			$row_key = $row->getRowKey();
			$cells = $row->getCells();
			for ($j = 0; $j < count($cells); $j++) {
				$cell = $cells[$j];
				$family_name = $cell->getFamily();
				$qualifier = $cell->getQualifier();
				$value = $cell->getValue();
				$timestamp_micros = $cell->getTimestamp();

				echo '<br>'.' Row key : '.$row_key;
				echo '<br>'.' Family Name : '.$family_name;
				echo '<br>'.' Qualifier Name : '.$qualifier;
				echo '<br>'.' Timestamp : '.$timestamp_micros;
				echo '<br>'.' value : '.$value;
				echo '<br>';
			}
		}

		//delete table
		$this->print("Delete table ".$this->tableName);
		try {
			$bigtableTable->deleteTable($formatedTable);
		}
		 catch (Exception $e) {
			$this->print("Deleting table error ".$e->getMessage());
		}

	}

	private function print($msg)
	{
		echo "HelloWorld: $msg <br>";
	}
}

$projectId = "grass-clump-479";
$instanceId = "hello-bigtable";
$HelloWorld = new HelloWorld();
$HelloWorld->doHelloWorld($projectId, $instanceId);
?>
