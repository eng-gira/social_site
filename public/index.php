<?php
    //DIRECTORY CONSTANTS
    define ('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
    define ('VIEW', ROOT . 'views' . DIRECTORY_SEPARATOR);
    define ('MODEL', ROOT . 'models' . DIRECTORY_SEPARATOR);
    define ('DATA', ROOT . 'data' . DIRECTORY_SEPARATOR);
    define ('CORE', ROOT . 'core' . DIRECTORY_SEPARATOR);
    define ('CONTROLLER', ROOT . 'controllers' . DIRECTORY_SEPARATOR);

    //URL CONSTANTS
    define ('WWW', 'localhost/ekom/');
    define ('_PUBLIC', WWW . 'public/');

    // echo dirname(__DIR__); -> C:\xampp\htdocs\ekom_proj
//    echo "index.php here!<br>";

    //setting include-paths for the autoloader
    $modules = [ROOT, CORE, MODEL, CONTROLLER, DATA];
    set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));
    //PATH_SEPARATOR --> ;

    //AUTO LOAD
    spl_autoload_register('spl_autoload', false);
?>
    <link rel="stylesheet" href="\social_site\inc\css\bootstrap.css">
    <link rel="stylesheet" href="\social_site\inc\css\ekom_custom.css">
    <script src="\social_site\inc\js\social_site_functions.js"></script>
<?php
    new Application;    
?>
