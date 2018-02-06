<?php namespace App\Helpers;

class PageDataHelper
{
    public static function pageData($data)
    {

    }
    public static function metaRobots($isNoindex, $isNofollow)
    {
        $values = [];
        $result = '';
        if ($isNoindex) {
            $values[] = 'noindex';
        }
        if ($isNofollow) {
            $values[] = 'nofollow';
        }

        if (count($values) > 1) {
            $content = implode(',', $values);
            $result = '<meta name="robots" content="' . $content . '">';
        } elseif(count($values) > 0) {
            $result = '<meta name="robots" content="' . $values[0] . '">';
        }

        return $result;

    }
}