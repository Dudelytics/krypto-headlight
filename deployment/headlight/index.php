<?php
declare(strict_types=1);
// Stable public entry; no provider calls, user data, or dynamic destinations.
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, follow');
header('Location: https://dudelytics.github.io/krypto-headlight/', true, 302);
exit;
