<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RssService
{
    protected $feeds = [
        'ANTARA Terkini' => 'https://www.antaranews.com/rss/terkini.xml',
        'ANTARA Top News' => 'https://www.antaranews.com/rss/top-news.xml',
        'CNN Indonesia'   => 'https://www.cnnindonesia.com/rss',
    ];

    public function fetch()
    {
        foreach ($this->feeds as $source => $url) {

            $response = Http::timeout(30)->get($url);

            if (!$response->successful()) {
                continue;
            }

            $body = preg_replace(
                '/&(?!#?[a-z0-9]+;)/',
                '&amp;',
                $response->body()
            );

            $xml = simplexml_load_string($body);

            if (!$xml) {
                continue;
            }

            foreach ($xml->channel->item as $item) {

                $title = (string) $item->title;
                $link  = (string) $item->link;

                if (Article::where('original_link', $link)->exists()) {
                    continue;
                }

                $slug = $this->makeSlugUnique($title);

                $image = null;

                if (preg_match(
                    '/<img.*?src=["\'](.*?)["\']/',
                    (string) $item->description,
                    $match
                )) {
                    $image = $match[1];
                }

                if (!$image && isset($item->enclosure)) {
                    $image = (string) $item->enclosure['url'];
                }

                $description = strip_tags((string) $item->description);

                Article::create([
                    'title'         => $title,
                    'description'   => $description,
                    'content'       => $description,
                    'full_content'  => null,
                    'summary'       => null,
                    'image'         => $image ?: 'https://via.placeholder.com/600x400',
                    'source'        => $source,
                    'slug'          => $slug,
                    'link'          => $slug,
                    'original_link' => $link,
                    'published_at'  => Carbon::parse((string) $item->pubDate),
                ]);
            }
        }
    }

    protected function makeSlugUnique($title)
    {
        $slug = Str::slug($title);

        $original = $slug;
        $i = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }
}