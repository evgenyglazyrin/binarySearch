<?php

//Тестовое задание для PHP программиста
//Написать функцию, реализующую бинарный поиск значения по ключу в текстовом файле.
//Аргументы: имя файла, значение ключа
//Результат: если найдено: значение, соответствующее ключу, если не найдено: undef
//Исходные данные и требования к реализации:
//1. Объем используемой памяти не должен зависеть от размера файла, только от максимального размера записи.
//2. Формат файла: ключ1\tзначение1\x0Aключ2\tзначение2\x0A...ключN\tзначениеN\x0A Где: \x0A - разделитель записей (код ASCII: 0Ah) \t - разделитель ключа и значения (табуляция, код ASCII: 09h) Символы разделителей гарантированно не могут встречаться в ключах или значениях. Записи упорядочены по ключу в лексикографическом порядке с учетом регистра. Все ключи гарантированно уникальные.
//3. Ограничений на длину ключа или значения нет.
//Функция на файле размером 10Гб с записями длиной до 4000 байт должна отрабатывать любой запрос менее чем за 5 секунд.
//

define('ROOT', dirname(__FILE__));

function getArrayFromTextFile($fileName)
{
    $file_handle = fopen($fileName, 'r');
    while (!feof($file_handle)) {
        $line = fgets($file_handle, 4000);
        $array = explode('\x0A', $line);
        array_pop($array);
        foreach ($array as $key => $value) {
            $arr[] = explode('\t', $value);
        }
    }
    fclose($file_handle);
    return $arr;
}

function binarySearch($fileName, $valueToSearch){
    $array =  getArrayFromTextFile($fileName);
    $start = 0;
    $end = count($array) - 1;
    while ($start <= $end){
        $mid = floor( ($start + $end)/2);
        $stringComparisonResult = strnatcmp($array[$mid][0], $valueToSearch);
        if($stringComparisonResult == 0){
            return $array[$mid][1];
        }
        elseif ($stringComparisonResult < 0){
            $start = $mid + 1;
        }
        else{
            $end = $mid - 1;
        }
    }
    return 'undef';
}

$fileName = ROOT."/example.txt";
$valueToSearch = 'ключ5217';
echo binarySearch($fileName, $valueToSearch);
