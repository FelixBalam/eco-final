<?php

// Generar hash de contraseña compatible con Yii2
$passwordHash = password_hash('ErvinBalam2001', PASSWORD_BCRYPT);

// Generar auth_key aleatoria
$authKey = bin2hex(random_bytes(16));

// Generar verification_token
$verificationToken = bin2hex(random_bytes(16)) . '_' . time();

echo "HASH:\n";
echo $passwordHash;

echo "\n\nSQL COMPLETO:\n\n";

echo "
INSERT INTO user (
    username,
    auth_key,
    password_hash,
    password_reset_token,
    email,
    rol_id,
    estado_id,
    tipo_usuario_id,
    created_at,
    updated_at,
    verification_token
) VALUES (
    'Ervin Balam',
    '$authKey',
    '$passwordHash',
    NULL,
    'ervinbalam@correo.com',
    1,
    1,
    1,
    NOW(),
    NOW(),
    '$verificationToken'
);
";
?>