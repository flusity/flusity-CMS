<?php

$mail_config = [
  'host' => 'your-server',
  'username' => 'info@yourmail.com',
  'password' => 'your-password',
  'secure' => 'tls',
  'port' => 587,
  'setFrom' => 'info@yourmail.com',
  'addAddress' => 'info@yourmail.com',
];

return $mail_config;
