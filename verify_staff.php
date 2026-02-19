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
    })->with('user')->get();

    echo "Found " . $staffs->count() . " staff members in block id 3.\n";
    foreach ($staffs as $s) {
        echo "Staff: " . $s->user->name . " | Role: " . $s->user->role . " | School: " . $s->school->name . "\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
