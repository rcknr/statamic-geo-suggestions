<?php

namespace Statamic\Addons\GeoSuggestions\SuggestModes;

class DemonymSuggestMode extends CountrySuggestMode
{
    /**
     * Get the suggestions.
     *
     * @return array
     */
    public function suggestions()
    {
        return $this->map(collect(countries(true))
            ->pluck('demonym')
            ->filter()
            ->values()
            ->all());
    }
}