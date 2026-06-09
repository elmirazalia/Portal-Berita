<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\User;
use App\Services\RssService;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;

/*
|--------------------------------------------------------------------------
| HOMEPAGE
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| DETAIL BERITA
|--------------------------------------------------------------------------
*/
Route::get('/berita/{slug}', [DetailController::class, 'show']);

/*
|--------------------------------------------------------------------------
| FETCH RSS
|--------------------------------------------------------------------------
*/
Route::get('/fetch-rss', function () {

    app(RssService::class)->fetch();

    return "RSS berhasil diambil";
});

/*
|--------------------------------------------------------------------------
| CHAT AI → FASTAPI
|--------------------------------------------------------------------------
*/
Route::post('/ask-ai', function (Request $request) {

    try {

        $response = Http::timeout(120)->post(
            'http://127.0.0.1:9000/ask',
            [
                'question' => $request->question,
                'context' => substr(
                    strip_tags($request->context),
                    0,
                    12000
                )
            ]
        );

        if (!$response->successful()) {

            return response()->json([
                'answer' => 'AI Server Error'
            ]);
        }

        return response()->json([
            'answer' => $response->json()['answer']
                ?? 'Tidak ada jawaban'
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'answer' => 'FastAPI belum aktif / error'
        ]);
    }
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
	Route::get('/dashboard', function () {

    return view('admin.dashboard', [
        'totalArtikel' => Article::count(),
        'totalUser' => User::count(),
    ]);

})->middleware('auth')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | TULIS BERITA
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/create', function () {

        return view('admin.create');

    });

    /*
    |--------------------------------------------------------------------------
    | SIMPAN BERITA
    |--------------------------------------------------------------------------
    */
	Route::post('/admin/store', function () {

    $imagePath = null;

    if (request()->hasFile('image')) {

        $imagePath = request()
            ->file('image')
            ->store('images', 'public');
    }

    Article::create([
        'title'         => request('title'),
        'description'   => request('description'),
        'content'       => request('content'),
        'summary'       => request('summary'),
        'original_link' => request('original_link'),
        'source'        => 'Internal',
        'image'         => $imagePath
            ? Storage::url($imagePath)
            : null,
        'slug'          => Str::slug(request('title')).'-'.time(),
        'published_at'  => now(),
    ]);

    return redirect('/dashboard');
});

    /*
    |--------------------------------------------------------------------------
    | DATA ARTIKEL
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/articles', function () {

        $articles = Article::latest()->paginate(10);

        return view('admin.articles', compact('articles'));

    });

    /*
    |--------------------------------------------------------------------------
    | DATA USER
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/users', function () {

        $users = User::all();

        return view('admin.users', compact('users'));

    });

    /*
    |--------------------------------------------------------------------------
    | UPDATE ROLE USER
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/users/{user}/role', function (
        Request $request,
        User $user
    ) {

        $user->update([
            'role' => $request->role
        ]);

        return back();

    });

});

/*
|--------------------------------------------------------------------------
| TEST GEMINI
|--------------------------------------------------------------------------
*/
Route::get('/test-summary', function () {

    $apiKey = env('GEMINI_SUMMARY_KEY');

    $response = Http::post(
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=".$apiKey,
        [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => "Ringkas berita berikut: Presiden datang ke Jakarta untuk rapat nasional."
                        ]
                    ]
                ]
            ]
        ]
    );

    return [
        'status' => $response->status(),
        'body' => $response->json()
    ];
});

require __DIR__.'/auth.php';