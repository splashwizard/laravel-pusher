<?php

use Illuminate\Database\Seeder;

class PusherTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pusher')->delete();
        
        \DB::table('pusher')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
                'device_id' => '8ba6847f116c1e05',
                'registration_id' => 'fSACsVscLJk:APA91bF2CUu_-uLr23_nLkUB84Nk-TtT6XQlYFRfIkEX5FFp_zl0I3USsXoTxuL7tJg4PI8XpcZH8wvXxl7aoAPK7Tbyk1c35TInyTeDd0Zdxuh2lXBiI-BJTlsxv5FY-wYQEZxKwzsb',
                'push_enable' => 'TRUE',
                'platform' => 'ANDROID',
                'user_email' => 'testaccount2@gmail.com',
            ),
        ));
        
        
    }
}