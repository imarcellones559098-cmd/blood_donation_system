<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$users = Illuminate\Support\Facades\DB::table('users')->select('id','email','name','role','created_at')->where('role','donor')->get();
foreach ($users as $u) {
    echo "{$u->id}\t{$u->email}\t{$u->name}\t{$u->role}\t{$u->created_at}\n";
}
