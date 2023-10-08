<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(public_path("data/countries.json"));
        $countries = json_decode($json);
        $colors = [];
        $flag = false; 
        
        foreach ($countries as $key => $value) {

            do {
                $randomColor = $this->generateRandomColor();
                if(!in_array($randomColor, $colors)){
                    $flag = true;
                    $colors[] = $randomColor;
                }
    
            } while($flag == false);

            Country::create([
                "name" => trim($value->name),
                "code" => trim($value->alpha2),
                "color" => $randomColor
            ]);
        }
    }

    /**
    * Generate a random color, used for country color    
    */
    function generateRandomColor(){
        $randomcolor = '#' . strtoupper(dechex(rand(0,10000000)));
        if (strlen($randomcolor) != 7){
            $randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
            $randomcolor = substr($randomcolor,0,7);
        }
        return $randomcolor;
    }
}
