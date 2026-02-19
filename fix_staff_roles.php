<?php

use App\Models\Staff;
use App\Models\User;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $staffs = Staff::whereHas('school', function($q) {
        $q->where('block_id', 3);
    })->get();

    echo "Found " . $staffs->count() . " staff records in block id 3.\n";
    foreach ($staffs as $s) {
        $u = $s->user;
        if ($u) {
            echo "Staff: " . $u->name . " | Role: " . $u->role . " | School: " . $s->school->name . "\n";
            if ($u->role !== 'officer') {
                echo "--- WARNING: User has role {$u->role}, but needs 'officer' for leave dropdown.\n";
                $u->update(['role' => 'officer']);
                echo "--- Fixed: Updated role to 'officer'.\n";
            }
        } else {
            echo "--- ERROR: Staff ID {$s->id} has NO USER.\n";
        }
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
