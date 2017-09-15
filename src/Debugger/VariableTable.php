<?php

namespace Google\Cloud\Debugger;

class VariableTable implements \JsonSerializable
{
    const MAX_MEMBER_DEPTH = 5;

    private $nextIndex = 0;
    private $variables = [];
    private $sharedVariableIndex = [];

    public function register($name, $value, $depth = 0)
    {
        $name = (string)$name;
        $type = gettype($value);
        $index = $this->nextIndex;
        $members = [];
        $shared = false;

        switch ($type) {
            case 'object':
                $type = get_class($value);
                $hash = spl_object_hash($value);

                if (array_key_exists($hash, $this->sharedVariableIndex)) {
                    $index = $this->sharedVariableIndex[$hash];
                    $shared = true;
                } else {
                    $this->sharedVariableIndex[$hash] = $index;
                    $valueString = "$type ($hash)";
                    $members = get_object_vars($value);
                }
                break;
            case 'array':
                $arraySize = count($value);
                $valueString = "array ($arraySize)";
                $members = $value;
                break;
            case 'NULL':
                $valueString = 'NULL';
            default:
                $valueString = (string)$value;
        }

        if (!$shared) {
            $variable = new Variable([
                'name' => $name,
                'type' => $type,
                'value' => $valueString
            ]);
            if ($depth < self::MAX_MEMBER_DEPTH) {
                foreach ($members as $key => $member) {
                    array_push($variable->members, $this->register($key, $member, $depth + 1));
                }
            }
            $this->nextIndex++;
            array_push($this->variables, $variable);
        }
        return new Variable([
            'name' => $name,
            'type' => $type,
            'varTableIndex' => $index
        ]);
    }

    public function jsonSerialize()
    {
        return $this->variables;
    }
}
