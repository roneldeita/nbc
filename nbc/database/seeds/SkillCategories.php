<?php

use Illuminate\Database\Seeder;

class SkillCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$skill_categories = array(
    		'Design, Animations and Multimedia',
    		'Web Development',
    		'Programming',
			'Software Development',
			'Web Host & Server Management',
			'Mobile Applications',
			'Writing & Content',
			'Administrative Support',
			'Customer Service',
			'Sales & Marketing',
			'Business Services',
			'Finance & Management',
			'Engineering, Manufacturing & Science',
			'Translation & Languages',
			'General Computer Skills',
			'Journalist'
   		);


    	foreach($skill_categories as $categories){

    		DB::table('skill_categories')->insert([
	         	'name' => $categories
	        ]);
    	}
    	
        
    }
}
