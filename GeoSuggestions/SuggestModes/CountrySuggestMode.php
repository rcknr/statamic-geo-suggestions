<?php

namespace Statamic\Addons\GeoSuggestions\SuggestModes;

use Statamic\Addons\Suggest\Modes\AbstractMode;

class CountrySuggestMode extends AbstractMode
{
    /**
     * Get the suggestions.
     *
     * @return array
     */
    public function suggestions()
    {
        return $this->map(collect(countries())
            ->pluck('name', 'iso_3166_1_alpha2')
            ->all());
    }

    protected function map(array $suggestions)
    {
        return array_map(function($value, $key) {
            return [
                'text' => $value,
                'value' => $key ?: $value
            ];
        }, $suggestions, array_values($suggestions) === $suggestions ? [] : array_keys($suggestions));
    }
}