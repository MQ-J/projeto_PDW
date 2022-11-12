<?php

namespace App\Helpers;

final class Permalink
{
    private static array $replacebleChars = [
        "á" => "a",
        "à" => "a",
        "â" => "a",
        "ã" => "a",
        "ä" => "a",
        "é" => "e",
        "è" => "e",
        "ê" => "e",
        "ë" => "e",
        "í" => "i",
        "ì" => "i",
        "î" => "i",
        "ó" => "o",
        "ò" => "o",
        "õ" => "o",
        "ô" => "o",
        "ú" => "u",
        "ù" => "u",
        "ü" => "u",
    ];

    public static function generatePermalink(string $title): string
    {
        foreach (Permalink::$replacebleChars as $specialChar => $normalChar)
            $title = str_replace($specialChar, $normalChar, $title);

        $title = trim(($title));
        $title = utf8_encode(strtolower($title));

        return str_replace(" ", "-", $title);
    }
}
