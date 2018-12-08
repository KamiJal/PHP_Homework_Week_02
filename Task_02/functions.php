<?php

const DICTIONARY_FILENAME = 'dictionary.txt';

function isRealCountryName(string $countryName)
{
    $dictionary = readCountriesFromFile(DICTIONARY_FILENAME);

    if (!isset($dictionary))
        return false;

    return in_array($countryName, $dictionary);
}

function readCountriesFromFile(string $filename)
{
    if (!file_exists($filename))
        return null;

    $handle = fopen($filename, 'r');
    //IN CASE IF fopen RETURNED FALSE
    if (!$handle)
        return null;

    $countries = null;
    while (!feof($handle)) {
        $countries = explode("|", fgets($handle));
    }
    fclose($handle);

    //IN CASE IF FILE IS EMPTY
    if (empty($countries[0]))
        return null;

    return $countries;
}

function response(bool $status, string $message)
{
    return ['status' => ($status ? 'success' : 'error'), 'message' => $message];
}

function saveCountryToFile(string $filename, string $countryName)
{
    if (empty($countryName))
        return response(false, 'Country name field can not be empty!');

    if(!isRealCountryName($countryName))
        return response(false, 'There is no such country!');

    $countriesInFile = readCountriesFromFile($filename);
    if (isset($countriesInFile)) {
        if (in_array($countryName, $countriesInFile)) {
            return response(false, 'Country already recorded to file!');
        }
    }

    $handle = fopen($filename, 'a');
    //IN CASE IF fopen RETURNED FALSE
    if (!$handle)
        return response(false, 'Opening file failed!');

    $status = fwrite($handle, $countryName . "|");
    fclose($handle);

    //IN CASE IF fwrite RETURNED FALSE
    if (!$status)
        return response(false, 'Saving file failed!');

    return response(true, 'Country successfully written to file!');
}
