<?php

use App\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [];
        $old  = DB::connection('old')
            ->table('news')
            ->get();

        foreach ($old as $item) {

            if ($item->published) {
                $post        = new News;
                $post->title = $item->title;
                $post->body  = $item->content;

                $post->save();

                try {
                    if (filter_var($item->thumb, FILTER_VALIDATE_URL) === false) {
                        $post
                            ->addMediaFromUrl('http://www.idnexporter.com/' . $item->thumb)
                            ->usingFileName(md5(time()))
                            ->toMediaCollection('featured_image');
                    } else {
                        $post
                            ->addMediaFromUrl($item->thumb)
                            ->usingFileName(md5(time()))
                            ->toMediaCollection('featured_image');
                    }
                } catch (Exception $e) {

                }
            }
        }
    }

}
