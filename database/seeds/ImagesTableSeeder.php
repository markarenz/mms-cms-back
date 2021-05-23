<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('m_m_s_images')->truncate();
      DB::table('m_m_s_images')->insert([
          'filename' => 'mms-page-headers-01.jpg',
          'alt' => 'Mms Page Headers 01',
      ]);
    }
}
