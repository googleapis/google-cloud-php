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
        $members = [];
        $shared = false;
        $variable = new Variable([
            'name' => $name,
            'type' => gettype($value)
        ]);

        switch ($variable->type) {
            case 'object':
                $type = get_class($value);
                $hash = spl_object_hash($value);

                if (array_key_exists($hash, $this->sharedVariableIndex)) {
                    $index = $this->sharedVariableIndex[$hash];
                    $shared = true;
                } else {
                    $index = $this->nextIndex;
                    $this->sharedVariableIndex[$hash] = $index;
                    $variable->type = $type;
                    $variable->value = "$type ($hash)";

                    if ($depth < self::MAX_MEMBER_DEPTH) {
                        foreach (get_object_vars($value) as $key => $member) {
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
                break;
            case 'array':
                $arraySize = count($value);
                $variable->value = "array ($arraySize)";
                if ($depth < self::MAX_MEMBER_DEPTH) {
                    foreach ($value as $key => $member) {
                        array_push($variable->members, $this->register($key, $member, $depth + 1));
                    }
                }
                break;
            case 'NULL':
                $variable->value = 'NULL';
            default:
                $variable->value = (string)$value;
        }

        return $variable;
    }

    public function jsonSerialize()
    {
        return $this->variables;
    }
}
