<?php
/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (! function_exists('dump')) {

    function dump($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        } else {
            return $output;
        }
    }
}

if (! function_exists('dump_exit')) {

    function dump_exit($var, $label = 'Dump', $echo = TRUE)
    {
        dump($var, $label, $echo);
        exit();
    }
}

function textile_sanitize($string)
{
    $whitelist = '/[^a-zA-Z0-9а-яА-ЯéüртхцчшщъыэюьЁуфҐ \.\*\+\\n|#;:!"%@{} _-]/';
    return preg_replace($whitelist, '', $string);
}

function escape($string)
{
    return textile_sanitize($string);
}

if (! function_exists('currency_format')) {

    function currency_format($number)
    {
        return 'Rp ' . number_format($number, 2, ',', '.');
    }
}

function date_convert($date)
{
    $date = date('Y-m-d', strtotime($date)); // ubah sesuai format penanggalan standart
    $bulan = array(
        '01' => 'Januari', // array bulan konversi
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );
    $date = explode('-', $date); // ubah string menjadi array dengan paramere '-'
    
    return $date[2] . ' ' . $bulan[$date[1]] . ' ' . $date[0]; // hasil yang di kembalikan
}

function getMonthName($date)
{
    $ret = '';
    switch ($date) {
        case '1':
            $ret = 'Januari';
            break;
        case '2':
            $ret = 'Februari';
            break;
        case '3':
            $ret = 'Maret';
            break;
        case '4':
            $ret = 'April';
            break;
        case '5':
            $ret = 'Mei';
            break;
        case '6':
            $ret = 'Juni';
            break;
        case '7':
            $ret = 'Juli';
            break;
        case '8':
            $ret = 'Agustus';
            break;
        case '9':
            $ret = 'September';
            break;
        case '10':
            $ret = 'Oktober';
            break;
        case '11':
            $ret = 'November';
            break;
        case '12':
            $ret = 'Desember';
            break;
        case '':
            $ret = '-';
        default:
            $ret = "-";
            break;
    }
    return $ret;
}