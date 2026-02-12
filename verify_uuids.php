<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$db = $app->make('db');

// Check for null UUIDs
$nullCount = $db->table('user')->whereNull('uuid')->count();
echo "=== UUID Verification ===\n\n";
echo "Users with NULL uuid: " . $nullCount . "\n\n";

// Get all admin/petugas users
$admins = $db->table('user')->where('role', '!=', 0)->select('id_user', 'nama', 'role', 'uuid')->get();
echo "Admin/Petugas Users:\n";
echo str_repeat("-", 80) . "\n";
foreach ($admins as $u) {
    $uuid = $u->uuid ? substr($u->uuid, 0, 12) . '...' : 'NULL';
    echo sprintf("  ID: %2d | Role: %d | Nama: %-20s | UUID: %s\n",
        $u->id_user, $u->role, substr($u->nama, 0, 20), $uuid);
}
echo str_repeat("-", 80) . "\n";

// Get all users
$allUsers = $db->table('user')->select('id_user', 'uuid')->get();
echo "\nTotal users with UUID: " . $allUsers->where('uuid', '!=', null)->count() . " / " . count($allUsers) . "\n";
