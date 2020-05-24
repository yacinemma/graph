<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Graph;

class GraphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < rand(10,50); $i++) { 
	    	Graph::create([
	            'name' => 'graph_'.Str::random(8),
	            'description' => Str::random(80),
	        ]);
    	}
    }
}
