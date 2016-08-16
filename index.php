<?php
    require_once('facebookParser.php');

    $parser = new FacebookParser('524285880946743');
    $content = $parser->parse();
    echo $content;
?>