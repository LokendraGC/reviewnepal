<?php
$user = null;
try {
    echo $user->name ?? 'Fallback';
} catch (\Throwable $e) {
    echo "Caught: " . $e->getMessage();
}
echo "\n";
echo $user?->name ?? 'Fallback Safe';
