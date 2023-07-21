<?php

namespace App\Service;


/**
 * This class implements utils methods for teams.
 * 
 * */
final class TeamUtils
{

    /**
     * Create a slug based on the team name
     * 
     * @var string $name
     * @var string $divider
     * @return string
     */
    public static function slugify($name, string $divider = '-'):string
    {
        // replace non letter or digits by divider
        $name = preg_replace('~[^\pL\d]+~u', $divider, $name);

        // transliterate
        $name = iconv('utf-8', 'us-ascii//TRANSLIT', $name);

        // remove unwanted characters
        $name = preg_replace('~[^-\w]+~', '', $name);

        // trim
        $name = trim($name, $divider);

        // remove duplicate divider
        $name = preg_replace('~-+~', $divider, $name);

        // lowercase
        $name = strtolower($name);

        if (empty($name)) {
            return 'n-a';
        }

        return $name;
    }
}
