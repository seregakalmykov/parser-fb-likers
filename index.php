<?php

    require(dirname(__FILE__).'/vendor/autoload.php');
    require(dirname(__FILE__).'/app/helpers/simple_html_dom.php');

    $parser = new \liw\app\FacebookParser('524285880946743', 2); //page id & count of "scrolling"

    $content = $parser->parse(); // init

    $persons = \liw\app\PrepareData::prepare($content);

    echo '<pre>';
    var_dump($persons);



?>