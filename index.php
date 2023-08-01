<?php
header('Content-Type: application/json; charset=utf-8');

require './scraping/simple_html_dom.php';

function checkStatus($class)
{
    if($class == "table-danger"){
        return "Tavsiya etilmagan";
    }elseif($class == "table-warning"){
        return "To'lov shartnoma asosida qabul qilingan";
    }elseif($class == "table-success"){
        return "Davlat Granti asosida asosida qabul qilingan";
    }else{
        return "Natijalar hali aniqlanmagan";
    }
}


function getData($id){
    // Saytga tashrif buyurish
    $cookies = [
        '.AspNetCore.Antiforgery.bnDOLbEMdVI' => 'CfDJ8F3I5rKVjAdFl2G6l0yqVr6VVhbiBMTJMdk7lo7RkMzcSlBAnMaQ2SZzQbU-APWsQI1d1UfQIBr5YYezV7_f-kJ5dD7RdVHYO8RwUXKxXbrjoyoRuR8fKfyDP363CS0d_pPyrmQMkDKV1KEPK7wcGd4',
        '.AspNetCore.Culture' => 'c%3Duz%7Cuic%3Duz', // Atayin Cookie fayllar joylab qo'yildi, O'zgartirish shart emas
    ];
    $cookieStr = '';
    foreach ($cookies as $name => $value) {
        $cookieStr .= "$name=$value; ";
    }
    $options = [
        'http' => [
            'header' => "Cookie: $cookieStr\r\n",
            'method' => 'GET',
        ],
    ];
    $context = stream_context_create($options);
    $html = file_get_html("https://mandat.uzbmb.uz/Home2023/AfterFilter?name=".$id, false, $context);

    // Saytdan html kodlarni o'qiymiz
    $dom = str_get_html($html);
    $rows = $dom->find('table tr');

    $data = array();
    $data['ok'] = True;
    $data['users'] = [];

    // Malumotlarni olib va chiqaramiz
    foreach ($rows as $row) {
        $class = $row->getAttribute('class');
        $cells = $row->find('td');
        
        if (count($cells) === 8) {
            $abituriyentId = $cells[0]->plaintext;
            $fio = $cells[1]->plaintext;
            $direction = $cells[2]->plaintext;
            $institute = $cells[3]->plaintext;
            $point = $cells[4]->plaintext;
            $language = $cells[5]->plaintext;
            $form = $cells[6]->plaintext;
            $url = $cells[7]->find('a', 0)->href;
            $status = checkStatus($class);
            
            // Abituriyent malumotlarini yozib olamiz
            $info = array();
            $info['id'] = $abituriyentId;
            $info['fio'] = $fio;
            $info['direction'] = $direction;
            $info['institute'] = $institute;
            $info['point'] = $point;
            $info['language'] = $language;
            $info['form'] = $form;
            $info['url'] = "https://mandat.uzbmb.uz".$url;
            $info['status'] = $status;
            
            $data['users'][] = $info;
        }
    }
    return $data;
}


// Get so'rovi orqali API ko'rinishiga keltirdik
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = getData($id);

    echo json_encode($data);
}else{
    $data = array();
    $data['ok'] = False;
    $data['error'] = "The id variable was not entered";
    echo json_encode($data);
}

// $$$$$$$$$$$$$$$$$$$$$$$$  DTM MANDAT FUNC API  $$$$$$$$$$$$$$$$$$$$$$$$ \\
// $$$$$$$$$$$$$$$$$$$$$$$$   Source: @iCoderNet  $$$$$$$$$$$$$$$$$$$$$$$$ \\
// $$$$$$$$$$$$$$$$$$$$$$$$     Dev: @NinetyDev   $$$$$$$$$$$$$$$$$$$$$$$$ \\


# Ko'pchilik 10$+ sotayotgan kod 
# @iCoderNet Kanaliga a'zo bo'ling, Hali hammasi oldinda...
# Sizlar bilan @NinetyDev, Yordam kerak bo'lsa, profilimni bilasiz!
?>
