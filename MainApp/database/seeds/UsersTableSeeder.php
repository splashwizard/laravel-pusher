<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => '$2y$10$EyYvexwSF/gAxkHkAP3.XuMKQi7aTKlfk7tDIH9eHjmKmQUM3mqJ.',
                'remember_token' => 'lDDiazxIYPGSwFeVW3WQBZLRDwcMnzf9l0T0ALYYphsGBycZwUmkYdRBJXbC',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}