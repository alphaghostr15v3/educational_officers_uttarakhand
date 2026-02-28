<?php

$directories = [__DIR__ . '/app', __DIR__ . '/routes', __DIR__ . '/database', __DIR__ . '/resources/views'];

foreach ($directories as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            $newContent = str_replace('state_admin', 'admin_panel', $content);
            $newContent = str_replace('State Admin', 'Admin Panel', $newContent);
            $newContent = str_replace('State admin', 'Admin panel', $newContent);
            $newContent = str_replace('state admin', 'admin panel', $newContent);
            $newContent = str_replace('badge-state', 'badge-admin-panel', $newContent);
            
            if ($content !== $newContent) {
                file_put_contents($file->getPathname(), $newContent);
                echo "Updated: " . str_replace(__DIR__ . '\\', '', $file->getPathname()) . "\n";
            }
        }
    }
}
echo "Done replacing strings in files.\n";

// Now, update database
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('users')->where('role', 'state_admin')->update(['role' => 'admin_panel']);
echo "Updated users table.\n";
