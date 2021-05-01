<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'api_token' => '1287h918hs8128as1iu21iuueh19[hd981ue9019e8h192hsp198hd1929182hs181hq9182udh',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
        ]);
        $user->admin()->create([
            'user_id' => $user->id,
            'name' => 'admin'
        ]);
    }
}
