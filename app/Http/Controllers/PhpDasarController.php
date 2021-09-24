<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhpDasarController extends Controller
{
    public function soal_1_view()
    {
        return view('php_dasar.soal_1');
    }
    public function soal_1(Request $request)
    {
        $nilai = $request->nilai;
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
        $data['average'] = $average;
        $data['input'] = $nilai;
        $data['terendah'] = $terendah;
        $data['tertinggi'] = $tertinggi;
        return redirect()->back()->with($data);
    }

    public function soal_2_view()
    {
        return view('php_dasar.soal_2');
    }
    public function soal_2(Request $request)
    {
        $string = $request->string;
        $lower = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] >= 'a' && $string[$i] <= 'z') $lower++;
        }
        $data = ([
            'string' => $string,
            'lower' => $lower,
        ]);
        return redirect()->back()->with($data);
    }

    public function soal_3_view()
    {
        return view('php_dasar.soal_3');
    }
    public function soal_3(Request $request)
    {
        $string = $request->string;
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
        $data = ([
            'input' => $request->string,
            'unigram' => $unigram,
            'bigram' => $bigram,
            'trigram' => $trigram,
        ]);
        return redirect()->back()->with($data);
    }

    public function soal_5_view()
    {
        return view('php_dasar.soal_5');
    }
    public function soal_5(Request $request)
    {
        $string = $request->string;
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
        return redirect()->back()->with(['message' => 'Enkripsi dari ' . $request->string . ' adalah ' . $enkripsi]);
    }

    public function soal_6_view()
    {
        return view('php_dasar.soal_6');
    }
    public function soal_6(Request $request)
    {
        $arr = [
            ['f', 'g', 'h', 'i'],
            ['j', 'k', 'p', 'q'],
            ['r', 's', 't', 'u']
        ];
        $string = $request->string;
        $string = strtolower($string);
        $cari = $this->cari($arr, $string);
        return redirect()->back()->with(['message' => $string . ' // ' . $cari]);
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
