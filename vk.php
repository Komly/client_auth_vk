<?php
error_reporting(E_ALL);

$app_id = '4467317';
$auth_url = "https://oauth.vk.com/authorize?".
"client_id=$app_id&".
"scope=groups&".
"redirect_uri=https://oauth.vk.com/blank.html&".
"display=popup&".
"v=5.34&".
"response_type=token";

function vk_call($method, $params = array(), $token = null) {
    $params = array_merge($params, array(
        'v' => '5.34',
    ));
    if ($token) {
        $params['access_token'] = $token;
    }
    $url = "https://api.vk.com/method/$method?" . http_build_query($params);
    $resp = file_get_contents($url);
    if ($resp !== false) {
        return json_decode($resp, true);
    }
    return false;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $group_id = $_POST['group_id'];

    $resp = vk_call('groups.getBanned', array(
        'group_id' => $group_id
    ), $token);

    die(var_dump($resp));
}

?>

<form method="POST">
    <p><a href="<?= $auth_url ?>" target="_blank">Get token</a></p>
    <p>Copy your token from adress bar here:</p>
    <p><input type="text" name="token"></p>
    <p>Group id for banned people:</p>
    <p><input type="text" name="group_id"></p>
    <p><input type="submit"></p>
</form>

