<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\System\Bigtable;

require_once __DIR__ .'/../../../vendor/autoload.php';

use Google\ApiCore\ServerStream;
use Google\ApiCore\ValidationException;
use Google\ApiCore\Testing\MockServerStreamingCall;
use Google\Cloud\Bigtable\Cell;
use Google\Cloud\Bigtable\ChunkFormatter;
use Google\Cloud\Bigtable\FlatRow;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse_CellChunk;
use PHPUnit\Framework\TestCase;

/**
 * Check the test cases for the row read rows of table
 * Read the json file and chek the each test cases like New row, Row In Progress, Cell In Progress for the row
 */
class ReadRowsAcceptanceTest extends TestCase
{

	private $flatRows = [];
	private $errorCount;

	public function testReadJson()
	{
		echo "\n Read Row Acceptance tests \n";
		echo "------------------------------------------------------- \n";
		$schema = json_decode(file_get_contents(__DIR__ . '/../data/read-rows-acceptance-test.json'), true);
		$tests = $schema['tests'];// decode the JSON into an associative array
		foreach ($tests as $test) {
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
		// $this->assertEquals($this->errorCount , $actualError);
		// $this->assertEquals(count($this->flatRows) , count($actualFlatRows));
		$this->assertEquals($this->flatRows, $actualFlatRows);
	}

	private function initializeResults($test) {
		$rawResults = ($test['results'])?$test['results']:[];
		// print_r($rawResults);
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
			$flatRow = null;

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
