<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhpDasarController extends Controller
{
    public function soal_1()
    {
        $nilai = '72 65 73 78 75 74 90 81 87 65 55 69 72 78 79 91 100 40 67 77 86';
        $nilais = explode(" ", $nilai);
        $average = array_sum($nilais) / count($nilais);
        sort($nilais);
        $tertinggiArr = $nilais;
        rsort($nilais);
        $terendahArr = $nilais;
        $tertinggi = '';
        $terendah = '';
        for ($i = 0; $i < 7; $i++) {
            $tertinggi .= $tertinggiArr[$i] . ' ';
            $terendah .= $terendahArr[$i] . ' ';
        }
        echo 'Nilai Rata rata : ' . $average;
        echo '<Br>';
        echo 'Nilai Terendah : ' . $terendah;
        echo '<Br>';
        echo 'Nilai Tertinggi : ' . $tertinggi;
    }

    public function soal_2()
    {
        $string = 'TranSISI';
        $lower = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] >= 'a' && $string[$i] <= 'z') $lower++;
        }
        echo '"' . $string . '" mengandung ' . $lower . ' buah huruf kecil';
    }

    public function soal_3()
    {
        $string = 'Jakarta adalah ibukota negara Republik Indonesia';
        $unigram = '';
        $bigram = '';
        $trigram = '';
        $countBi = 1;
        $countTri = 1;
        $strings = explode(" ", $string);
        foreach ($strings as $index => $string) {
            if ($index == 0) {
                $unigram .= $string;
                $bigram .= $string;
                $trigram .= $string;
            } else {
                $unigram .= ', ' . $string;
                if ($countBi < 2) {
                    $bigram .= ' ' . $string;
                    $countBi++;
                } else {
                    $bigram .= ', ' . $string;
                    $countBi = 1;
                }
                if ($countTri < 3) {
                    $trigram .= ' ' . $string;
                    $countTri++;
                } else {
                    $trigram .= ', ' . $string;
                    $countTri = 1;
                }
            }
        }
        echo 'Unigram : ' . '"' . $unigram . '"';
        echo '<Br>';
        echo 'Bigram : ' . '"' . $bigram . '"';
        echo '<Br>';
        echo 'Trigram : ' . '"' . $trigram . '"';
    }

    public function soal_5()
    {
        $string = 'DFHKNQ';
        $string = strtoupper($string);
        $plus = true;
        $enkripsi = '';
        $y = 1;
        for ($i = 0; $i < strlen($string); $i++) {
            if ($plus == true) {
                $next_character = chr(ord($string[$i]) + $y);
                $plus = false;
            } else {
                $next_character = chr(ord($string[$i]) - $y);
                $plus = true;
            }
            $y++;
            $enkripsi .= $next_character;
        }
        echo $enkripsi;
    }

    public function soal_6()
    {
        $arr = [
            ['f', 'g', 'h', 'i'],
            ['j', 'k', 'p', 'q'],
            ['r', 's', 't', 'u']
        ];
        $string = 'fghq';
        $string = strtolower($string);
        $cari = $this->cari($arr, $string);
        echo $string . ' // ' . $cari;
    }

    public function cari($arrays, $string)
    {
        $index_1 = 0;
        $index_2 = 0;
        foreach ($arrays as $index => $array) {
            foreach ($array as $index2 => $arr) {
                if ($arr == $string[0]) {
                    $index_1 = $index;
                    $index_2 = $index2;
                }
            }
        }
        for ($i = 1; $i < strlen($string); $i++) {
            if ($arrays[$index_1 + 1][$index_2] == $string[$i]) {
                $index_1++;
            } else if ($arrays[$index_1][$index_2 + 1] == $string[$i]) {
                $index_2++;
            } else {
                return 'false';
                break;
            }
        }
        return 'true';
    }
}
