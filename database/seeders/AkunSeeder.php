<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CATATAN SEGERA GANTI IMAGE
        $users = [
            [
                'username' => 'adminone',
                'name'=>'Krab',
                'email'=>'admin@example.com',
                'level'=>'admin',
                'password'=> bcrypt('123456'),
                'image'=>'https://i.pinimg.com/736x/e3/86/23/e38623cb61d5499381052b2a75a7f60a.jpg',
            ],
            [
                'username' => 'squidward',
                'name'=>'Squidward Tentancles',
                'email'=>'squid@example.com',
                'level'=>'kasir',
                'password'=>bcrypt('000000'),
                'image'=>'https://s2.bukalapak.com/img/7993091873/large/Squidward.png',
            ],
            [
                'username' => 'gudangers',
                'name'=>'Patrick Star',
                'email'=>'gudang@example.com',
                'level'=>'gudang',
                'password'=>bcrypt('gedang'),
                'image'=>'https://i.pinimg.com/474x/5a/06/bb/5a06bba392b434406b406182f6e038d6--science-facts-cool-things.jpg',
            ],
        ];

        \DB::table('users')->insert($users);
    }
}
