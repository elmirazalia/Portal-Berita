<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleScraperService;
use App\Services\SummaryService;

class DetailController extends Controller
{
    public function show(
        $slug,
        ArticleScraperService $scraper,
        SummaryService $summaryService
    ) {

        $article = Article::where('slug', $slug)
            ->firstOrFail();


        if (
            !$article->full_content ||
            strlen($article->full_content) < 500
        ) {

            $fullContent = $scraper->fetchFullContent(
                $article->original_link
            );

            if ($fullContent) {

                $article->full_content = $fullContent;

                $article->save();
            }
        }

        if (!$article->summary) {

            $text = $article->full_content
                ?? $article->content
                ?? $article->description;

            $summary = $summaryService->summarize(
                substr(strip_tags($text), 0, 5000)
            );

            if ($summary) {

                $article->summary = $summary;

                $article->save();
            }
        }

        return view('detail', compact('article'));
    }
}