<?php
ini_set('display_errors', 1);
ob_start();

define('API_KEY', '6350828837:AAF6AxqIlRHRIRsPBLDpIyYJ317XAW7emfA');
$admin = "6277848912";


$bot = bot('getMe', ['bot'])->result->username;
echo file_get_contents('https://api.telegram.org/bot' . API_KEY . '/setwebhook?url=' . $_SERVER["SERVER_NAME"] . '' . $_SERVER["SCRIPT_NAME"]);

function bot($method, $datas = [])
{
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}


$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$text = $message->text;
$cid = $message->chat->id;


if ($text == "/start") {
    bot("sendMessage",[
        "chat_id"=>$cid,
        "text"=>"<b>👋 Assalomu Alaykum botimiz orqali Mandat natijalarini bilishigiz mumkin\n\n🆔 Abituriyent ID raqamini kiriting:</b>",
        "parse_mode"=>"html",
    ]);
}


if (ctype_digit($text)){
    bot("sendMessage",[
        "chat_id"=>$cid,
        "text"=>'⏳',
    ]);
    $data = json_decode(file_get_contents("https://u9068.xvest5.ru/mandat/index.php?id=".$text));
    if ($data->ok) {
        if (count($data->users) > 0) {
            foreach ($data->users as $user) {
                bot("sendMessage",[
                    "chat_id"=>$cid,
                    "text"=>"<b>🆔ID :</b>  ".$user->id."
<b>👤F.I.O :</b>  ".$user->fio."
<b>➕Yo'nalish :</b> ".$user->direction."
<b>📋Holati :</b> ".$user->status." 
<b>📍Oliy ta'lim muassasasi :</b> ".$user->institute."
<b>📊To'plagan ball :</b> ".$user->point."
<b>🌐Ta'lim tili :</b> ".$user->language."
<b>📃Ta'lim shakli :</b> ".$user->form."",
                    "parse_mode"=>"html",
                    "reply_markup"=>json_encode([
                        "inline_keyboard"=>[
                        [["text"=>"❇️ Batafsil","url"=>$user->url]],
                        ]
                        ]),
                ]);
            }
        }else{
            bot("sendMessage",[
                "chat_id"=>$cid,
                "text"=>"<b>❌ Bu ID raqam ostida abituriyent topilmadi, ID raqamni tekshirib qayta yuboring!</b>",
                "parse_mode"=>"html",
            ]);
        }
    }else{
        bot("sendMessage",[
            "chat_id"=>$cid,
            "text"=>$data->error,
        ]);
    }
}


// $$$$$$$$$$$$$$$$$$$$$$$$  MANDAT BOT API ASOSIDA  $$$$$$$$$$$$$$$$$$$$$$$$ \\
// $$$$$$$$$$$$$$$$$$$$$$$$    Source: @iCoderNet    $$$$$$$$$$$$$$$$$$$$$$$$ \\
// $$$$$$$$$$$$$$$$$$$$$$$$      Dev: @NinetyDev     $$$$$$$$$$$$$$$$$$$$$$$$ \\


# Kanalgan joylangan Mandat API kodi uchun yozilgan Mandat Bot kodi
# @iCoderNet Kanaliga a'zo bo'ling, Hali hammasi oldinda...
# Sizlar bilan @NinetyDev, Yordam kerak bo'lsa, profilimni bilasiz!
?>