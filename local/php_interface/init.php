<?php
/** HighLoad события */

// Тут конечно можно использовать autoload, но пока что у нас только один файл
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/HighLoadChangeEvent.php")) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/HighLoadChangeEvent.php");
}
