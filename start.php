<?php

$string = 'Контейнер был запущен в ' . gmdate("Y-m-d H:i:s");
file_put_contents('startServer.log', $string);