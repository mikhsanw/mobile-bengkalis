<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public $userpass='root';

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('users')->insert([[
            'id'=>\Ramsey\Uuid\Uuid::uuid4()->toString(),
            'username'=>'root',
            'nama'=>'root',
            'password'=>bcrypt($this->userpass),
            'aksesgrup_id'=>1,
            'level'=>1,
            'email'=>'root@mail.com',
            'email_verified_at'=>date("Y-m-d H:i:s"),
        ],
        [
            'id'=>\Ramsey\Uuid\Uuid::uuid4()->toString(),
            'username'=>'kim',
            'nama'=>'kim',
            'password'=>bcrypt('kimkim'),
            'aksesgrup_id'=>2,
            'level'=>2,
            'email'=>'kim@mail',
            'email_verified_at'=>date("Y-m-d H:i:s"),
        ]]);
        Schema::enableForeignKeyConstraints();
    }
}
