<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Goutte\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use PDF;

class CrawlerController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('comment_count', 'DESC')->get();

        return view('welcome', compact('posts'));
    }

    public function crawler(Request $request)
    {
        $url = 'https://sample.kan-tek.com/blog.html';

        $client = new Client();

        $crawler = $client->request('GET', $url);
        $crawler->filter('article.post')->slice(0, $request->get('number_posts', 1))->each(
            function (DomCrawler $node) {
                $title = $node->filter('h2.post-title a')->text();
                $image = 'https://sample.kan-tek.com/' . $node->filter('figure.card-img-top img')->attr('src');
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

        return redirect('/');
    }

    public function exportPDF($postId)
    {
        $post = Post::find($postId);
        $pdf = PDF::loadView('pdf', [
            'title' => $post->title,
            'description' => $post->description,
            'image' => $post->image,
            'commentCount' => $post->comment_count,
            'category' => $post->category,
        ]);

        return $pdf->download('post.pdf');
    }
}
