<?php

namespace AppStoreLibrary\Helpers;

use Symfony\Component\Intl\Countries;

class CountryHelper
{
    /**
     * @throws \Exception
     */
    public static function alpha3ToAlpha2(string $countryCode): string
    {
        if (strlen($countryCode) != 3) {
            throw new \InvalidArgumentException("Country Code must be 3 alpha.");
        }
        try {
            return Countries::getAlpha2Code($countryCode);
        } catch (\Exception $e) {
            /**
             * https://github.com/symfony/symfony/issues/40020
             * Kosovo doesn`t exists in ISO 3166 list but European services (like Apple) returns XKS
             */
            return match ($countryCode) {
                'XKS' => 'XK',
                default => mb_substr($countryCode, start: 0, length: 2),
            };
        }
    }

    /**
     * @throws \Exception
     */
    public static function alpha2ToAlpha3(string $countryCode): string
    {
        if (strlen($countryCode) != 2) {
            throw new \InvalidArgumentException("Country Code must be 2 alpha.");
        }
        try {
            return Countries::getAlpha3Code($countryCode);
        } catch (\Exception $e) {
            /**
             * https://github.com/symfony/symfony/issues/40020
             * Kosovo doesn`t exists in ISO 3166 list but European services (like Apple) returns XKS
             */
            return match ($countryCode) {
                'XK' => 'XKS', // Kosovo
                default => throw $e,
            };
        }
    }
}
