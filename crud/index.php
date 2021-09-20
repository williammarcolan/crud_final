<?php

include "./config.php";

include DIR_TEMPLATE."header.php";

spl_autoload_register(function ($classe) {
    include "./classes/" . $classe . ".php";
});

if(isset($_GET["pagina"])){
    include DIR_HOME.$_GET["pagina"].'.php';
}

include DIR_TEMPLATE."footer.php";
