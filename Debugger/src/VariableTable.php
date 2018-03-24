<?php

namespace Google\Cloud\Debugger;

/**
 * This class represents a collection of Variables that are referenced by index
 * within a Breakpoint. Its main use to reduce duplication of identical objects
 * by checking a unique identifier for objects.
 *
 * Example:
 * ```
 * use Google\Cloud\Debugger\VariableTable;
 *
 * $variableTable = new VariableTable();
 * ```
 */
class VariableTable implements \JsonSerializable
{
    const MAX_MEMBER_DEPTH = 5;

    /**
     * @var int The next index to use for the variable table
     */
    private $nextIndex;

    /**
     * @var Variable[] List of all variables
     */
    private $variables;

    /**
     * @var array Associative array of all variables indexed by object hash.
     */
    private $sharedVariableIndex;

    /**
     * Initialize a new VariableTable with optional initial values.
     *
     * @param Variable[] $initialVariables
     */
    public function __construct(array $initialVariables = [])
    {
        $this->variables = $initialVariables;
        $this->nextIndex = count($this->variables);
        $this->sharedVariableIndex = [];
    }

    /**
     * Register a variable in the VariableTable and return a Variable reference.
     * The reference should be stored in the correct Breakpoint location.
     *
     * Example:
     * ```
     * $variableReference = $variableTable->register('varName', 'some value');
     * ```
     *
     * @param string $name The name of the variable
     * @param mixed $value The value of the variable
     * @return Variable
     */
    public function register($name, $value)
    {
        return $this->doRegister($name, $value, 0);
    }

    /**
     * Callback to implement JsonSerializable interface
     *
     * @access private
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->variables;
    }

    /**
     * Return the shared variables
     *
     * Example:
     * ```
     * $variables = $variableTable->variables();
     * ```
     *
     * @return Variable[]
     */
    public function variables()
    {
        return $this->variables;
    }

    private function doRegister($name, $value, $depth, $index = null)
    {
        $name = (string)$name;
        $members = [];
        $shared = false;
        $type = gettype($value);
        $variableValue = null;

        switch ($type) {
            case 'object':
                $type = get_class($value);
                $hash = spl_object_hash($value);

                if (array_key_exists($hash, $this->sharedVariableIndex)) {
                    $index = $this->sharedVariableIndex[$hash];
                    $shared = true;
                } else {
                    $index = $this->nextIndex;
                    $this->sharedVariableIndex[$hash] = $index;

                    $members = [];
                    if ($depth < self::MAX_MEMBER_DEPTH) {
                        foreach (get_object_vars($value) as $key => $member) {
                            array_push($members, $this->doRegister($key, $member, $depth + 1));
                        }
                    }

                    $this->nextIndex++;
                    array_push($this->variables, new Variable($name, $type, [
                        'value' => "$type ($hash)",
                        'members' => $members
                    ]));
                }
                return new Variable($name, $type, [
                    'varTableIndex' => $index
                ]);
                break;
            case 'array':
                $arraySize = count($value);
                $members = [];
                if ($depth < self::MAX_MEMBER_DEPTH) {
                    foreach ($value as $key => $member) {
                        array_push($members, $this->doRegister($key, $member, $depth + 1));
                    }
                }
                return new Variable($name, $type, [
                    'value' => "array ($arraySize)",
                    'members' => $members
                ]);
                break;
            case 'NULL':
                $variableValue = 'NULL';
                break;
            default:
                $variableValue = (string)$value;
        }

        return new Variable($name, $type, [
            'value' => $variableValue
        ]);
    }
}
