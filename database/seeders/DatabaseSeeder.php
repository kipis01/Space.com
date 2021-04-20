<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Forum;
use App\Models\Forum_Comment;
use App\Models\News;
use App\Models\News_Comment;
use App\Models\Wiki;
use App\Models\Wiki_Contributor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $time = \Carbon\Carbon::now();

        DB::table('Users')->insert([
            'id' => '1',
            'Username' => 'Admin',
            'password' => Hash::make('Admin'),
            'role' => 'Admin',
            'remember_token' => '',
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        DB::table('Users')->insert([
            'id' => '2',
            'Username' => 'Editor',
            'password' => Hash::make('Editor'),
            'role' => 'Editor',
            'remember_token' => '',
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        DB::table('Users')->insert([
            'id' => '3',
            'Username' => 'User',
            'password' => Hash::make('User'),
            'role' => 'User',
            'remember_token' => '',
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        DB::table('Forum')->insert([
            'id' => '1',
            'Author' => '1',
            'Title' => 'First post',
            'Date' => $time,
            'Message' => 'This is the first post!',
            'HasAttachments' => true,
        ]);

        DB::table('Forum')->insert([
            'id' => '2',
            'Author' => '2',
            'Title' => 'Second post',
            'Date' => $time,
            'Message' => 'As you could probably tell, this is the second post...',
            'HasAttachments' => false,
        ]);
    }
}
