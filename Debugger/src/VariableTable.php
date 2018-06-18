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
    const DEFAULT_MAX_MEMBER_DEPTH = 5;
    const DEFAULT_MAX_PAYLOAD_SIZE = 32768; // 32KB
    const DEFAULT_MAX_MEMBERS = 1000;
    const BUFFER_FULL_MESSAGE = 'Buffer full. Use an expression to see more data.';
    const MIN_REQUIRED_SIZE = 100;
    const DEFAULT_MAX_STRING_LENGTH = 500;

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
     * @var int Maximum depth of member variables to capture.
     */
    private $maxMemberDepth;

    /**
     * @var int Maximum string length of the captured variable value.
     */
    private $maxValueLength;

    /**
     * @var int Max number of variables to evaluate in compound variables.
     */
    private $maxMembers;

    /**
     * @var int|null The index of the shared "buffer-full" variable.
     */
    private $bufferFullVariableIndex;

    /**
     * @var int Maximum amount of space of captured data.
     */
    private $maxPayloadSize;

    /**
     * @var int The amount of space used for captured data.
     */
    private $bytesUsed = 0;

    /**
     * Initialize a new VariableTable with optional initial values.
     *
     * @param Variable[] $initialVariables
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxMemberDepth Maximum depth of member variables to capture.
     *           **Defaults to** 5.
     *     @type int $maxPayloadSize Maximum amount of space of captured data.
     *           **Defaults to** 32768.
     *     @type int $maxMembers Maximum number of member variables captured per
     *           variable. **Defaults to** 1000.
     *     @type int $maxValueLength Maximum length of the string representing
     *           the captured variable. **Defaults to** 500.
     * }
     */
    public function __construct(array $initialVariables = [], array $options = [])
    {
        $this->variables = $initialVariables;
        $this->nextIndex = count($this->variables);
        $this->setOptions($options);
        $this->sharedVariableIndex = [];
    }

    /**
     * Update evaluation options.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxMemberDepth Maximum depth of member variables to capture.
     *           **Defaults to** 5.
     *     @type int $maxPayloadSize Maximum amount of space of captured data.
     *           **Defaults to** 32768.
     *     @type int $maxMembers Maximum number of member variables captured per
     *           variable. **Defaults to** 1000.
     *     @type int $maxValueLength Maximum length of the string representing
     *           the captured variable. **Defaults to** 500.
     * }
     */
    public function setOptions(array $options = [])
    {
        $options += [
            'maxMemberDepth' => self::DEFAULT_MAX_MEMBER_DEPTH,
            'maxPayloadSize' => self::DEFAULT_MAX_PAYLOAD_SIZE,
            'maxMembers' => self::DEFAULT_MAX_MEMBERS,
            'maxValueLength' => self::DEFAULT_MAX_STRING_LENGTH
        ];
        $this->maxMemberDepth = $options['maxMemberDepth'];
        $this->maxPayloadSize = $options['maxPayloadSize'];
        $this->maxValueLength = $options['maxValueLength'];
        $this->maxMembers = $options['maxMembers'];
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
     * Returns the reference for the buffer full variable.
     *
     * @return Variable
     */
    public function bufferFullVariable()
    {
        if (!$this->bufferFullVariableIndex) {
            $this->bufferFullVariableIndex = $this->nextIndex++;
            $this->variables[] = new Variable('', '', [
                'status' => new StatusMessage(
                    true,
                    StatusMessage::REFERENCE_VARIABLE_VALUE,
                    new FormatMessage(
                        self::BUFFER_FULL_MESSAGE
                    )
                )
            ]);
        }
        return new Variable('', '', [
            'varTableIndex' => $this->bufferFullVariableIndex
        ]);
    }

    /**
     * Returns whether or not the variable table is full or not.
     *
     * @return bool
     */
    public function isFull()
    {
        return $this->maxPayloadSize - $this->bytesUsed < self::MIN_REQUIRED_SIZE;
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
        if ($this->isFull()) {
            throw new BufferFullException();
        }

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
                $variableValue = $this->truncatedStringValue($value);
        }

        if ($hash) {
            // If this variable has an object hash, then save it in the
            // VariableTable and return a reference Variable to that entry.
            $index = $this->nextIndex;
            $this->sharedVariableIndex[$hash] = $index;
            $this->nextIndex++;

            $newVariable = new Variable($name, $type, [
                'value' => $variableValue,
                'members' => $members
            ]);
            $this->variables[] = $newVariable;

            // Deduct the size from the bytes remaining.
            $this->bytesUsed += $newVariable->byteSize();

            return new Variable($name, $type, [
                'varTableIndex' => $index
            ]);
        } else {
            $newVariable = new Variable($name, $type, [
                'value' => $variableValue,
                'members' => $members
            ]);

            // Deduct the size from the bytes remaining.
            $this->bytesUsed += $newVariable->byteSize();

            return $newVariable;
        }
    }

    private function truncatedStringValue($value)
    {
        $ret = (string)$value;
        if (strlen($ret) > $this->maxValueLength) {
            $ret = substr($ret, 0, $this->maxValueLength - 3) . '...';
        }
        return $ret;
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
        if ($depth >= $this->maxMemberDepth) {
            return [];
        }

        $members = [];
        $i = 0;
        foreach ($array as $key => $member) {
            if ($i >= $this->maxMembers) {
                break;
            }
            try {
                $members[] = $this->doRegister((string) $key, $member, $depth + 1, null);
                $i++;
            } catch (BufferFullException $e) {
                $members[] = $this->bufferFullVariable();
                break;
            }
        }
        return $members;
    }
}
