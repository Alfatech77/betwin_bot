<?php
$bot_token = "8766492558:AAED9ophEGjswQbYQdZTkfSP4pSxasZWD_0";
$api_url = "https://iambetwin.ct.ws/sistem/api.php";
$api_key = "betwin_ozel_sifre_123";

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'];
    $first_name = $update['message']['from']['first_name'] ?? 'Oyuncu';
    $username = $update['message']['from']['username'] ?? '';

    $post_data = json_encode([
        'key' => $api_key,
        'chat_id' => $chat_id,
        'first_name' => $first_name,
        'username' => $username
    ]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_REFERER, 'https://iambetwin.ct.ws/'); // Kritik ekleme
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0');
    curl_exec($ch);
    curl_close($ch);

    if (($update['message']['text'] ?? '') == "/start") {
        $msg = "Hoş geldin $first_name! Hesabın aktif edildi. 🎰";
        $keyboard = json_encode(['inline_keyboard' => [[['text' => '🎰 GİRİŞ YAP', 'web_app' => ['url' => 'https://iambetwin.ct.ws/index.php']]]]]);
        file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=".urlencode($msg)."&reply_markup=".urlencode($keyboard));
    }
}
echo "Vercel Bridge Active";
