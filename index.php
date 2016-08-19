<?php

    require(dirname(__FILE__).'/vendor/autoload.php');
    require(dirname(__FILE__).'/app/helpers/simple_html_dom.php');

    \liw\app\helpers\FacebookAuth::auth();
    \liw\app\helpers\FacebookAuth::auth();

    $parser = new \liw\app\FacebookParser('524285880946743', 4); //page id & count of "scrolling"
    $content = $parser->parse(); // init
    if ($content !== ''){
        $persons = \liw\app\PrepareData::prepare($content);

        $collection = [];
        foreach ($persons as $p) {
            $person = new stdClass();
            $person->name = $p['name'];
            $person->surname = $p['surname'];
            $person->img_url = $p['img_url'];
            $resource = new \alsvanzelf\jsonapi\resource($type='person');
            $resource->fill_data($person);
            $collection[] = $resource;
        }
        $jsonapi = new \alsvanzelf\jsonapi\collection($type='person');
        $jsonapi->fill_collection($collection);
        $jsonapi->send_response();
    } else {
        die ('incorect auth');
    }

    \liw\app\helpers\FacebookAuth::quit();
?>