<?php

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function criar_jwt($id_usuario) {
    $chave_secreta = "sua_chave_secreta";
    $header = base64UrlEncode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $payload = base64UrlEncode(json_encode([
        'iss' => "http://seusite.com",
        'iat' => time(),
        'exp' => time() + (60 * 60),
        'data' => [
            'id' => $id_usuario
        ]
    ]));
    $signature = hash_hmac('sha256', "$header.$payload", $chave_secreta, true);
    $jwt = "$header.$payload." . base64UrlEncode($signature);
    return $jwt;
}

function verificar_jwt($jwt) {
    $chave_secreta = "sua_chave_secreta";
    list($header, $payload, $signature) = explode('.', $jwt);
    $signature_verification = hash_hmac('sha256', "$header.$payload", $chave_secreta, true);
    if (base64UrlEncode($signature_verification) !== $signature) {
        return null;
    }
    $payload_decoded = json_decode(base64UrlDecode($payload), true);
    if ($payload_decoded['exp'] < time()) {
        return null;
    }
    return $payload_decoded['data'];
}

?>
