<?php // PHP 5.3.29
// Программа добавляет дополнительный столбец справа к уже имеющимся в файле (записанным в CSV-формате)
$n = 3; // Число столбцов
$m = 30000; // Число строк
$add = array();

file_put_contents('file_res.csv', '');

$fp = fopen('file.csv', 'w');

for($i = 0; $i < $m; $i++){ // Генерируем псевдослучайные числа для csv-файла
    $str = array();
    for ($j = 0; $j < $n; $j++){
        $str[] = substr(md5(md5(microtime(true)).rand(1, 5)), 0, rand(3, 15));
    }
    fputcsv($fp, $str, ',',  "\n");
    $add[] = substr(md5(md5(microtime(true)).rand(1, 5)), 0, rand(3, 15));
//    $add[] = 'ADDITION'; // Элементы этого массива будут добавлены в качестве 4-го столбца
//    usleep(1); // Для лучшей случайности
}
fclose($fp);

$add1 = $add;
// Будем добавлять дополнительный (4-й) столбец после 3-го столбца
$time0 = microtime(true); // Начальное время

// 1 Способ (array_map, array_merge)


$csv = array_map('str_getcsv', file('file.csv')); // Читаем исходный файл с пс.случ. числами
$str = array_map(function($v, $a) {
    $v =  array_merge($v, array($a)); // Если моменять местами $v , $a , то столбец добавится не на 4-е, а на 1-е место
    return implode(',', $v); //
}, $csv, $add);

$buffer = implode("\n", $str);
file_put_contents('file_res.csv', $buffer, FILE_APPEND);

$time1 = microtime(true);
echo 'Time: '. ($time1 - $time0) . ' c<br>';
echo 'Max script memory usage: '. (memory_get_usage(true)/1000000). ' M<br>';
echo 'Max PHP memory: '.  ini_get('memory_limit'). '<br>';
echo 'FileSize: '. (strlen($buffer)/1000000). ' M<br><br>';
unset($buffer);
unset($str);
unset($csv);

// 2 Способ (str_replace)
$fp = fopen('file.csv', 'r');
$buffer_All = '';

if ($fp) {
    while (($buffer = fgets($fp)) !== false) {

        $buffer = str_replace("\n", ','. array_shift($add)."\n", $buffer);
        $buffer_All .= $buffer;
    }
    if (!feof($fp)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($fp);
}
file_put_contents('file_res2.csv', $buffer_All);

$time2 = microtime(true);
echo 'Time: '. ($time2 - $time1) . ' c<br>';
echo 'Max script memory usage: '. (memory_get_usage(true)/1000000). ' M<br>';
echo 'Max PHP memory: '.  ini_get('memory_limit'). '<br>';
echo 'FileSize: '. (strlen($buffer_All)/1000000). ' M<br><br>';
unset($buffer_All);

// 3 Способ (preg_replace_callback
$buffer_All = file_get_contents('file.csv');
$buffer_All = preg_replace_callback("/\n/", function($matches) use (&$add1) {return ",". array_shift($add1). "\n";}, $buffer_All);
file_put_contents('file_res3.csv', $buffer_All);

$time3 = microtime(true);
echo 'For control: sizeof($add)='. sizeof($add).'<br>';
echo 'Time: '. ($time3 - $time2) . ' c<br>';
echo 'Max script memory usage: '. (memory_get_usage(true)/1000000). ' M<br>';
echo 'Max PHP memory: '.  ini_get('memory_limit'). '<br>';
echo 'FileSize: '. (strlen($buffer_All)/1000000). ' M<br><br>';
