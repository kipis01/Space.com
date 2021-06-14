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
            'email' => 'admin@space.com',
            'password' => Hash::make('Admin'),
            'role' => 'Admin',
            'remember_token' => '',
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        DB::table('Users')->insert([
            'id' => '2',
            'Username' => 'Editor',
            'email' => 'editor@space.com',
            'password' => Hash::make('Editor'),
            'role' => 'Editor',
            'remember_token' => '',
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        DB::table('Users')->insert([
            'id' => '3',
            'Username' => 'User',
            'email' => 'user@space.com',
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
            'created_at' => $time,
            'Message' => 'This is the first post!',
            'HasAttachments' => true,
        ]);

        DB::table('Forum')->insert([
            'id' => '2',
            'Author' => '2',
            'Title' => 'Second post',
            'created_at' => $time,
            'Message' => 'As you could probably tell, this is the second post...',
            'HasAttachments' => false,
        ]);

        DB::table('Forum_Comments')->insert([
            'id' => '1',
            'Post' => '1',
            'Author' => '2',
            'created_at' => $time,
            'Message' => 'The start of something new',
            'HasAttachments' => false,
        ]);

        DB::table('Forum_Comments')->insert([
            'id' => '2',
            'Post' => '1',
            'Author' => '3',
            'created_at' => $time,
            'Message' => 'Bump',
            'HasAttachments' => true,
        ]);
    }
}
