<?php

use App\Models\Block;
use App\Models\User;
use App\Models\School;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $block = Block::firstOrCreate(
        ['name' => 'CHAMBA', 'district_id' => 3],
        ['code' => 'CHM', 'is_active' => 1]
    );
    echo "Block CHAMBA (ID: {$block->id}) ensured.\n";

    $user = User::where('role', 'block_admin')->first();
    if ($user) {
        $user->update([
            'block_id' => $block->id,
            'district_id' => 3,
            'division_id' => 1 // Assuming 1 is the division for Tehri Garhwal, let's check
        ]);
        echo "User {$user->name} updated with block_id {$block->id}.\n";
    }

    $affected = School::where('block', 'CHAMBA')->update(['block_id' => $block->id]);
    echo "Updated {$affected} schools for block CHAMBA.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
