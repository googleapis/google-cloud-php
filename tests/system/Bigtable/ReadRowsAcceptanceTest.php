<?php

use Google\Bigtable\V2\ReadRowsResponse;
use Google\Bigtable\V2\ReadRowsResponse_CellChunk;
use Google\Cloud\Bigtable\V2\Cell;
use Google\Cloud\Bigtable\V2\ChunkFormatter;
use Google\Cloud\Bigtable\V2\FlatRow;
use Google\GAX\ServerStream;
use Google\GAX\Testing\MockServerStreamingCall;
use Google\GAX\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class ReadRowsAcceptanceTest extends TestCase
{

	private $flatRows = [];
	private $errorCount;

	public function testReadJson()
	{
		echo "\n Read Row Acceptance tests \n";
		echo "------------------------------------------------------- \n";
		$str  = file_get_contents('read-rows-acceptance-test.json');
		$json = json_decode($str, true)['tests'];// decode the JSON into an associative array

		foreach ($json as $test) {
			$this->flatRows = [];
			$this->runAcceptanceTest($test);
		}
	}

	public function runAcceptanceTest($test)
	{
		echo "\t".$test['name'];
		echo "\n";

		$this->initializeResults($test);
		$responses = [];
		foreach ($test['chunks_base64'] as $chunk) {
			$chunk = base64_decode($chunk);

			$cellChunk = new ReadRowsResponse_CellChunk();
			$cellChunk->mergeFromString($chunk);

			$ReadRowsResponse = new ReadRowsResponse();
			$ReadRowsResponse->setChunks([$cellChunk]);
			array_push($responses, $ReadRowsResponse);
		}

		$call           = new MockServerStreamingCall($responses);
		$stream         = new ServerStream($call);
		$actualError    = 0;
		$actualFlatRows = [];

		try {
			$chunkFormatter = new ChunkFormatter($stream, []);
			foreach ($chunkFormatter->readAll() as $flatRow) {
				array_push($actualFlatRows, $flatRow);
			}
		} catch (ValidationException $e) {
			$actualError = 1;
		}

		$this->assertEquals($this->errorCount , $actualError);
		$this->assertEquals(count($this->flatRows) , count($actualFlatRows));
		$this->assertEquals($this->flatRows, $actualFlatRows);
	}

	private function initializeResults($test) {
		$rawResults = ($test['results'])?$test['results']:[];
		$error      = array_filter($rawResults, function ($var) {
				return $var['error'] == 1;
			});

		$this->errorCount = count($error);
		$notError         = array_filter($rawResults, function ($var) {
				return $var['error'] == '' || $var['error'] == 0;
			});
		$rowKeytoFlatRow = array();
		foreach ($notError as $k => $result) {
			$RK      = $result['rk'];
			$flatRow = NULL;

			foreach ($this->flatRows as $row) {
				if ($row->getRowKey() == $RK) {
					$flatRow = $row;
					break;
				}
			}

			if (is_null($flatRow)) {
				$flatRow = new FlatRow();
				$flatRow->setRowKey($RK);
				array_push($this->flatRows, $flatRow);
			}

			$cell = new Cell();

			$cell->setFamily($result['fm']);
			$cell->setQualifier($result['qual']);
			$cell->setLabels($result['label']);
			$cell->setTimestamp($result['ts']);
			$cell->setValue($result['value']);
			$flatRow->addCell($cell);
		}
	}
}
?>