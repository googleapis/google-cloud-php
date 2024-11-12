<?php

namespace Google\Cloud\Spanner;

use Google\Cloud\Core\ApiHelperTrait;

trait FormatKeySetTrait
{
    use ApiHelperTrait;

    /**
     * @param array $keySet
     * @return array Formatted keyset
     */
    private function formatKeySet(array $keySet)
    {
        $keys = $this->pluck('keys', $keySet, false);
        if ($keys) {
            $keySet['keys'] = array_map(
                fn ($key) => $this->formatListForApi((array) $key),
                $keys
            );
        }

        if (isset($keySet['ranges'])) {
            $keySet['ranges'] = array_map(function ($rangeItem) {
                return array_map([$this, 'formatListForApi'], $rangeItem);
            }, $keySet['ranges']);

            if (empty($keySet['ranges'])) {
                unset($keySet['ranges']);
            }
        }

        return $keySet;
    }
}

