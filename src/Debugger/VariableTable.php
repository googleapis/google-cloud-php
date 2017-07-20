<?php

namespace Google\Cloud\Debugger;

class VariableTable implements \JsonSerializable
{
    const MAX_MEMBER_DEPTH = 5;

    private $nextIndex = 0;
    private $variables = [];

    public function register($name, $value, $depth = 0)
    {
        $name = (string)$name;
        $type = gettype($value);
        $index = $this->nextIndex;
        $members = [];

        switch ($type) {
            case 'object':
                $type = get_class($value);
                $index = spl_object_hash($value);
                $valueString = 'object';
                $members = get_object_vars($value);
                break;
            case 'array':
                $valueString = 'array';
                $members = $value;
                break;
            default:
                $valueString = (string)$value;
        }

        if (array_key_exists($index, $this->variables)) {
            return new Variable([
                'name' => $name,
                'type' => $type,
                'varTableIndex' => $this->variables[$index]->varTableIndex
            ]);
        } else {
            $variable = new Variable([
                'name' => $name,
                'type' => $type,
                'value' => $valueString,
                'varTableIndex' => $this->nextIndex
            ]);
            if ($depth < self::MAX_MEMBER_DEPTH) {
                foreach ($members as $index => $member) {
                    array_push($variable->members, $this->register($index, $member, $depth + 1));
                }
            }
            $this->variables[$index] = $variable;
            return new Variable([
                'name' => $name,
                'type' => $type,
                'varTableIndex' => $this->nextIndex++
            ]);
        }
    }

    public function jsonSerialize()
    {
        return array_values($this->variables);
    }
}
