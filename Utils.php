<?php

class Utils
{
    static public function parseUrl($queries)
    {
        $output = [];
        $tableQueries = explode("&",$queries);

        foreach($tableQueries as $key){
            $query = explode("=",$key);
            $output[$query[0]]=$query[1];
        }
        return $output;
    }

    static public function printError(string $str, bool $die = true)
    {
        if ($die) {
            die($str);
        }
        echo $str;
    }

    static public function parseDate(string $date)
    {
        setlocale (LC_TIME, 'fr_FR.utf8','fra');

        $strDate = strtotime($date);
        return strftime("%d %B %Y", $strDate);
    }

    static public function secureString($str, $replace = true)
    {
        if ($replace) {
            $str = preg_replace("/>.*?</s", "><", $str);
        }
        return htmlspecialchars(strip_tags($str), ENT_QUOTES, 'UTF-8');
    }

    static public function getTags($str, $charDelimiter = '#')
    {
        if (strpos($str, $charDelimiter) == false) return false;

        $tags = [];
        $strSplit = explode(' ', $str);

        foreach ($strSplit as $word) {
            if (strpos($word, $charDelimiter) !== false) {
                $tags[] = substr(trim($word),1);
            }
        }

        return $tags;
    }
}