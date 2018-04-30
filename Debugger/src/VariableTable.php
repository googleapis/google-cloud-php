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
class VariableTable
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
     * @param string|null $hash [optional] The object hash to use for deduping
     * @return Variable
     */
    public function register($name, $value, $hash = null)
    {
        return $this->doRegister($name, $value, 0, $hash);
    }

    /**
     * Return a serializable version of this object
     *
     * @access private
     * @return array
     */
    public function info()
    {
        return array_map(function ($v) {
            return $v->info();
        }, $this->variables);
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

    private function doRegister($name, $value, $depth, $hash)
    {
        $type = $this->calcuateType($value);
        $members = [];

        // If the variable already exists in the table (via object hash), then
        // return a reference Variable to that VariableTable entry.
        $hash = $hash ?: $this->calculateHash($value);
        if ($hash && array_key_exists($hash, $this->sharedVariableIndex)) {
            return new Variable($name, $type, [
                'varTableIndex' => $this->sharedVariableIndex[$hash]
            ]);
        }

        switch (gettype($value)) {
            case 'object':
                $variableValue = "$type ($hash)";
                $members = $this->doRegisterMembers(get_object_vars($value), $depth);
                break;
            case 'array':
                $arraySize = count($value);
                $variableValue = "array ($arraySize)";
                $members = $this->doRegisterMembers($value, $depth);
                break;
            case 'NULL':
                $variableValue = 'NULL';
                break;
            default:
                $variableValue = (string)$value;
        }

        if ($hash) {
            // If this variable has an object hash, then save it in the
            // VariableTable and return a reference Variable to that entry.
            $index = $this->nextIndex;
            $this->sharedVariableIndex[$hash] = $index;
            $this->nextIndex++;

            array_push($this->variables, new Variable($name, $type, [
                'value' => $variableValue,
                'members' => $members
            ]));
            return new Variable($name, $type, [
                'varTableIndex' => $index
            ]);
        } else {
            return new Variable($name, $type, [
                'value' => $variableValue,
                'members' => $members
            ]);
        }
    }

    private function calcuateType($value)
    {
        return is_object($value)
            ? get_class($value)
            : gettype($value);
    }

    private function calculateHash($value)
    {
        return is_object($value) ? spl_object_hash($value) : null;
    }

    private function doRegisterMembers($array, $depth)
    {
        $members = [];
        if ($depth < self::MAX_MEMBER_DEPTH) {
            foreach ($array as $key => $member) {
                $members[] = $this->doRegister((string) $key, $member, $depth + 1, null);
            }
        }
        return $members;
    }
}
