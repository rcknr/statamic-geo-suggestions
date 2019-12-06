# GeoSuggestions

Geography-related suggest modes.

## Installation

Copy the `GeoSuggestions` folder into `site/addons/` and run `php please update:addons`.

## Usage

**Example Fieldset**
```yaml
fields:
  country:
    type: suggest
    display: Country
    mode: geo-suggestions.country
```

This will get you a list of countries with corresponding 2-letter ISO codes as values.

## Customization

You can easily create your own suggest modes.
This addon comes with [rinvex/countries](https://github.com/rinvex/countries) library which has a lot of country-related data.

For instance, say you want to have a nationality field with a suggest mode.
You can use `countries()` helper to get the data for all countries and pick a value that you need.
For this particular scenario we need a key called `demonym`.

1. Create a class `DemonymSuggestMode` in `SuggestModes` directory extending `CountrySuggestMode`.
2. Play around with `countries()` helper using `php please tinker` to get the data you need. I came up with this:
    ```php
    collect(countries(true))
        ->pluck('demonym')
        ->filter()
        ->values()
        ->all();
    ```
    For this case I'm calling `countries(true)` to get a bigger data set which includes a demonym for each country.
    I'm wrapping it inside `collect()` to turn the array into a [Laravel Collection](https://laravel.com/docs/5.1/collections)
    to get many convenience methods it provides. Then I'm picking (plucking) a `demonym` key from each country record and filter the collection
    to get rid of empty records. After then I call `values()` to get only values from the collection stripping the keys and finally
    `all()` turn the collection back to an array.
3. Implement `suggestions()` method like you would do for a suggest mode.
4. Wrap the array you got in step 2 in `$this->map()` call. This will make sure you data will be formatted in a way that Statamic expects.
If you have a simple array, both values and text labels will be the same. But if you want to have different values simply make an assosiative array.
5. Finally, use your suggest mode in a fieldset with a suggest field:
    ```yaml
    fields:
      country:
        type: suggest
        display: Nationality
        mode: geo-suggestions.demonym
    ```

 