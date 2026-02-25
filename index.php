<?php $bot_token = "8766492558:AAED9ophEGjswQbYQdZTkfSP4pSxasZWD_0";
$api_url = "https://iambetwin.ct.ws/sistem/api.php";
$api_key = "betwin_ozel_sifre_123";

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if ($update && isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'];
    $first_name = $update['message']['from']['first_name'] ?? 'Oyuncu';
    $username = $update['message']['from']['username'] ?? '';
    $text = $update['message']['text'] ?? '';

    // 1. Veriyi InfinityFree API'sine Gönder
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'key' => $api_key,
        'chat_id' => $chat_id,
        'first_name' => $first_name,
        'username' => $username
    ]);
    curl_exec($ch);
    curl_close($ch);

    // 2. Kullanıcıya Yanıt Ver
    if ($text == "/start") {
        $msg = "Hoş geldin $first_name! Sistem Vercel üzerinden başarıyla bağlandı. 🚀";
        $keyboard = ['inline_keyboard' => [[['text' => '🎰 GİRİŞ YAP', 'web_app' => ['url' => 'https://iambetwin.ct.ws/index.php']]]]];
        
        $send_url = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=".urlencode($msg)."&reply_markup=".json_encode($keyboard);
        file_get_contents($send_url);
    }
}
echo "Vercel Bridge Active";
