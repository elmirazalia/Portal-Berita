<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ArticleScraperService
{
    public function fetchFullContent($url)
    {
        try {
            $html = Http::get($url)->body();

            // ambil isi <p>
            preg_match_all('/<p>(.*?)<\/p>/s', $html, $matches);

            $content = "";

            foreach ($matches[1] as $p) {
                $text = strip_tags($p);

                if (strlen($text) > 50) { // filter paragraf kecil
                    $content .= $text . "\n\n";
                }
            }

            return $content ?: null;

        } catch (\Exception $e) {
            return null;
        }
    }
}