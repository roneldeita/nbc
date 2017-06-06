<?php

use Illuminate\Database\Seeder;

class SecurityQuestions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('security_questions')->insert([
        	'id' => 1,
            'name' => 'What was the name of your first pet?'
        ]);

        DB::table('security_questions')->insert([
            'id' => 2,
            'name' => 'What is your dream job?'
        ]);
        
        DB::table('security_questions')->insert([
            'id' => 3,
            'name' => 'What is Your favorite movie?'
        ]);
    }
}
