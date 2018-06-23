<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 15/04/2017
 * Time: 3:01 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// format printing
function print_f($string)
{
    echo '<pre>';
    print_r($string);
    echo '</pre>';
}

// format printing
function print_end($string)
{
    echo '<pre>';
    print_r($string);
    echo '</pre>';
    die();
}


function randomString($len = 5){
    $seed = str_split('abcdefghi jklmnopqrstuvwxyz'
        .'ABCDEFGHIJKL MNOPQRSTUVWXYZ'
        .'0123456789 '); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, $len) as $k) $rand .= $seed[$k];

    return $rand;
}

function randomNumber($len = 5){
    $seed = str_split('0123456789'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, $len) as $k) $rand .= $seed[$k];

    return $rand;
}