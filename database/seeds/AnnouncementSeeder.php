<?php

use App\Models\Announcement;
use App\Models\News;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Announcement::create([
            'author' => env('APP_NAME') . ' Management',
            'title' => 'Nisi enim officia labore culpa minim consequat sit ut.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;',
            'lang' => 'en',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Announcement::create([
            'author' => env('APP_NAME') . ' Management',
            'title' => 'Nisi enim officia labore culpa minim consequat sit ut.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;',
            'lang' => 'en',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        Announcement::create([
            'author' => env('APP_NAME') . ' Management',
            'title' => 'Nisi enim officia labore culpa minim consequat sit ut.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;',
            'lang' => 'en',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        News::create([
            'author' => env('APP_NAME') . ' Management',
            'title' => 'Nisi enim officia labore culpa minim consequat sit ut.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;
                            &lt;br /&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim a, sunt cum dolores qui numquam quod saepe perspiciatis voluptatem molestias beatae inventore excepturi officia totam odit reiciendis perferendis! Deserunt, repudiandae.
                            &lt;br /&gt;',
            'lang' => 'en',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
