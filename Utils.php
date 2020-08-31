<?php

class Utils
{
    /**
     * Formate une URL et retourne ses paramètres
     *
     * @param string $queries
     * @return array
     */
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

    /**
     * Affiche un message d'erreur
     *
     * @param string $str
     * @param bool $die
     */
    static public function printError(string $str, bool $die = true)
    {
        if ($die) {
            die($str);
        }
        echo $str;
    }

    /**
     * Formate une date et retourne celle-ci en français
     *
     * @param string $date
     * @return string
     */
    static public function parseDate(string $date)
    {
        setlocale (LC_TIME, 'fr_FR.utf8','fra');

        $strDate = strtotime($date);
        return strftime("%d %B %Y", $strDate);
    }

    /**
     * Sécurise une chaine de caractère
     *
     * @param string $str
     * @param bool $replace
     * @return string
     */
    static public function secureString($str, $replace = true)
    {
        if ($replace) {
            $str = preg_replace("/>.*?</s", "><", $str);
        }
        return htmlspecialchars(strip_tags($str), null, 'UTF-8');
    }

    /**
     * Retourne un tableau de tags à partir d'une chaine de caractères
     *
     * @param string $str
     * @param string $charDelimiter
     * @return array|false
     */
    static public function getTags($str, $charDelimiter = '#')
    {
        if ($str[0] !== $charDelimiter && strpos($str, $charDelimiter) === FALSE) return false;

        $tags = [];
        $strSplit = explode(' ', $str);

        if (!empty($strSplit)) {
            foreach ($strSplit as $word) {
                if (strpos($word, $charDelimiter) !== false) {
                    $tags[] = substr(trim($word),1);
                }
            }
        } else {
            if($str[0] === $charDelimiter) $tags[] = substr($str,1);
        }


        return $tags;
    }
}