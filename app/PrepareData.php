<?php

namespace liw\app;


class PrepareData
{
    public static function prepare($data)
    {
        $persons = [];
        $preparedData = self::unComment($data);
        $html = str_get_html($preparedData);
        foreach ($html->find('._5und') as $userDiv){
            $part_name = self::getName($userDiv->find('._5d-5', 0)->innertext);
            $img = $userDiv->find('._fbBrowseXuiResult__profileImage', 0)->src;
            $persons[] = [
                'name' => $part_name['name'],
                'surname' => $part_name['surname'],
                'img_url' => $img,
            ];
        }
        return $persons;
    }

    public static function unComment($data)
    {
        $result = str_replace("<!--", "", $data);
        $result = str_replace("-->", "", $result);
        $result = str_replace("<code", "<div", $result);
        $result = str_replace("</code>", "</div", $result);

        return $result;
    }

    public static function getName($fullname)
    {
        $i = 0;
        $name = '';
        $surname = '';
        $l = strlen($fullname);
        while($fullname[$i]==' '){
            $i++;
        }
        while($fullname[$i]!=' '){
            $name .= $fullname[$i];
            $i++;
        }
        while($fullname[$i]==' '){
            $i++;
        }
        while($i<$l && $fullname[$i]!=' '){
            $surname .= $fullname[$i];
            $i++;
        }

        return [
            "name" => $name,
            "surname" => $surname,
        ];
    }

} 