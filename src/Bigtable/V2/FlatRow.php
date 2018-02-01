<?php

namespace Google\Cloud\Bigtable\V2;
class Cell
{
	private $family;
	private $qualifier;
	private $timestamp;
	private $value;
	private $labels;

	/**
	 * @param string $family
	 */
	public function setFamily($family)
	{
		$this->family = $family;
	}

	/**
	 * @return string
	 */
	public function getFamily()
	{
		return $this->family;
	}

	/**
	 * @param string $qualifier
	 */
	public function setQualifier($qualifier)
	{
		$this->qualifier = $qualifier;
	}

	/**
	 * @return string
	 */
	public function getQualifier()
	{
		return $this->qualifier;
	}

	/**
	 * @param integer $timestamp
	 */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	/**
	 * @return integer
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param string $label
	 */
	public function setLabels($label)
	{
		$this->labels = $label;
	}

	/**
	 * @return string
	 */
	public function getLabels()
	{
		return $this->labels;
	}

	/**
	 * Concat value
	 * @param string $value
	 */
	public function appendValue($value)
	{
		$this->value = $this->value.$value;
	}
}

class FlatRow
{

	private $rowKey = NULL;
	private $cells  = [];

	/**
	 * @param string $rowKey
	 * @param string $cells
	 */
	public function setFlatRow($rowKey, $cells)
	{
		$this->rowKey = $rowKey;
		$this->cells  = $cells;
	}

	/**
	 * Reset rowKey and cells
	 */
	public function reSetFlatRow()
	{
		$this->rowKey = '';
		$this->cells  = [];
	}

	/**
	 * @param string $rowKey
	 */
	public function setRowKey($rowKey)
	{
		$this->rowKey = $rowKey;
	}

	/**
	 * @return string
	 */
	public function getRowKey()
	{
		return $this->rowKey;
	}

	/**
	 * @param $cell Google\Cloud\Bigtable\V2\Cell
	 */
	public function setCells($cell)
	{
		$this->cells = $cell;
	}

	/**
	 * @return Google\Cloud\Bigtable\V2\Cell
	 */
	public function getCells()
	{
		return $this->cells;
	}

	/**
	 * @param $cell Google\Cloud\Bigtable\V2\Cell
	 */
	public function addCell($cell)
	{
		array_push($this->cells, $cell);
	}
}
?>