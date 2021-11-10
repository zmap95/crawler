<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

class Crawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'https://sample.kan-tek.com/blog.html';

        $client = new Client();

        $crawler = $client->request('GET', $url);
        $crawler->filter('article.post')->slice(0, 2)->each(
            function (DomCrawler $node) {
                $title = $node->filter('h2.post-title a')->text();
                $image = $node->filter('figure.card-img-top img')->attr('src');
                $description = $node->filter('div.post-content p')->text();
                $category = $node->filter('div.post-category a')->text();
                $commentCount = str_replace("Comment Count : ", '', $node->filter('div.card-footer li.post-comments a')->text());

                $post = new Post();
                $post->title = $title;
                $post->image = $image;
                $post->category = $category;
                $post->description = $description;
                $post->comment_count = $commentCount;
                $post->save();
            }
        );


        return Command::SUCCESS;
    }
}
