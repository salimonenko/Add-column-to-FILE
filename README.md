# Add-column-to-FILE
PHP-скрипт, добавляющий еще 1 столбец к 3-м имеющимся в csv-файле

Результаты:
$m=30.000:
Time: 0.30208897590637 c
Max script memory usage: 25.427968 M
Max PHP memory: 128M
FileSize: 1.200169 M

Time: 3.4731209278107 c
Max script memory usage: 7.602176 M
Max PHP memory: 128M
FileSize: 1.20017 M

For control: sizeof($add)=0
Time: 5.1101629734039 c
Max script memory usage: 6.029312 M
Max PHP memory: 128M
FileSize: 1.20017 M

$m=50.000:
Time: 0.5275661945343 c
Max script memory usage: 43.515904 M
Max PHP memory: 128M
FileSize: 2.00047 M

Time: 10.144800901413 c
Max script memory usage: 10.747904 M
Max PHP memory: 128M
FileSize: 2.000471 M

For control: sizeof($add)=0
Time: 17.454138040543 c
Max script memory usage: 11.010048 M
Max PHP memory: 128M
FileSize: 2.000471 M
