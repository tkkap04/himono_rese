<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            ['name' => '寿司', 'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg'],
            ['name' => '焼肉', 'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg'],
            ['name' => 'イタリアン', 'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg'],
            ['name' => '居酒屋', 'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg'],
            ['name' => 'ラーメン', 'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
