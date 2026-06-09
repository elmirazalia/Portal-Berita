<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsService
{
	public function fetch()
	{
		$response = Http::get('https://newsapi.org/v2/everything', [
			'language' => 'id',
			'domains'  => 'kompas.com,detik.com,cnnindonesia.com,tempo.co,mediaindonesia.com,republika.co.id,jawapos.com,bisnis.com,kontan.co.id,thejakartapost.com,bbc.com,tribunnews.com',
			'sortBy'   => 'publishedAt',
			'pageSize' => 50,
			'apiKey'   => config('services.newsapi.key'),
		]);

		return $response->json()['articles'] ?? [];
	}
}