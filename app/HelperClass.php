<?php

namespace App;

use Intervention\Image\ImageManagerStatic as Image;
use DB;

class HelperClass
{

    // public static function changeStatus($tableName,$id)
    // {
    //     $changeStatus = db::table($tableName)->find($id);

    //     if ($changeStatus->status == 1)
    //     {
    //         $changeStatus->update( [
    //             'status' => 0
    //         ]);
    //     }
    //     else
    //     {
    //         $changeStatus->update( [
    //             'status' => 1
    //         ]);
    //     }
    // }

    public static function _blogImage($file)
    {
        $data = getimagesize($file);
        $width = $data[0];
        $height = $data[1];

        $directory = 'public/uploads/blog_image/';
        if (!file_exists($directory))
            mkdir($directory);
        $logoUrl = $directory . ($name);
        Image::make($file)->resize(min(1200, $width), min(800, $height))->save($logoUrl);
        return $logoUrl;
    }


    /*This is last modified function for upload any image*/
    public static function UploadImage($file, $table = null, $directory = null, $width = null, $height = null)
    {
        $lastData = \DB::table($table)->find(\DB::table($table)->max('id'));

        if (@$lastData) {
            $maxId = $lastData->id + 1 + rand(100000000, 99999999999);
        } else {
            $maxId = '1' . +rand(100000000, 99999999999);
        }

        $data = getimagesize($file);
        $filename = $file->getClientOriginalName();
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $logoExtension = $file->getClientOriginalExtension();

        if (!file_exists($directory)) {
            mkdir($directory);
        }

        $logoUrl = $directory . ($name . '_' . $maxId . '.' . $logoExtension);

        if (@$width == null && @$height == null) {
            move_uploaded_file($file, "$directory$name" . '_' . $maxId . '.' . "$logoExtension");
        }

        if (@$width != null && @$height != null) {
            Image::make($file)->resize($width, $height)->save($logoUrl);
        }

        return $logoUrl;
    }

    public static function numberToWords($num)
    {
        $ones = array(
            0 => "Zero",
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        );

        $tens = array(
            0 => "Zero",
            1 => "Ten",
            2 => "Twenty",
            3 => "Thirty",
            4 => "Forty",
            5 => "Fifty",
            6 => "Sixty",
            7 => "Seventy",
            8 => "Eighty",
            9 => "Ninety"
        );

        $hundreds = array(
            "Hundred",
            "Thousand",
            "Million",
            "Billion",
            "Trillion",
            "Quardrillion"
        ); /*limit t quadrillion */

        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr, 1);
        $rettxt = "";

        foreach ($whole_arr as $key => $i) {
            while (substr($i, 0, 1) == "0")
                $i = substr($i, 1, 5);
            if ($i < 20) {
                /* echo "getting:".$i; */
                $rettxt .= @$ones[$i];
            } elseif ($i < 100) {
                if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
                if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
            } else {
                if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
                if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
            }

            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }

        if ($decnum > 0) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }

    public static function makeTree($headName, $headCode, $coaLists, $visit, $d)
    {
        $tree = "";

        if ($d == 0) {
            $tree .= "<li>$headName";
        } else {
            $tree .= "<li><a href='javascript:' onclick='loadData(" . $headCode . ")'>$headName</a>";
        }

        $p = 0;

        for ($i = 0; $i < count($coaLists->toarray()); $i++) {
            if (!$visit[$i]) {
                if ($headName == $coaLists->toarray()[$i]['parent_head_name']) {
                    $visit[$i] = true;
                    if ($p == 0) {
                        $tree .= "<ul>";
                    }
                    $p++;
                    $tree .= static::makeTree($coaLists->toarray()[$i]['head_name'], $coaLists->toarray()[$i]['head_code'], $coaLists, $visit, $d + 1);
                }
            }
        }

        if ($p == 0) {
            $tree .= "</li>";
        } else {
            $tree .= "</ul>";
        }

        return $tree;
    }

    public static function convertEnglishToBangla($englishNumber)
    {
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        return str_replace($englishDigits, $banglaDigits, $englishNumber);
    }
}
