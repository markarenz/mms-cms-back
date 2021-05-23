<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('pages')->truncate();

      DB::table('pages')->insert([
        'title' => 'Mark Makes Stuff',
        'slug' => 'mms-home',
        'status' => 1,
        'metadesc' => 'This is a meta description. Lorem ipsum dolor.',
        'content' => '[{"type":"page-header","id":"page-header","title":"Page Header","headline":"Lorem Ipsum","subhead":"Lorem Ipsum Sic Amet","photo":"mms-page-headers-01.jpg"}]'
      ]);
    }
}
