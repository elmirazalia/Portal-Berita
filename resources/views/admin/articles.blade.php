<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Artikel</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f6fa;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        .btn {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .delete {
            background: red;
            color: white;
            border: none;
            cursor: pointer;
        }

        .top {
            margin-bottom: 20px;
        }

        .top a {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<h1>Manajemen Artikel</h1>

<div class="top">
    <a href="/admin/dashboard">← Dashboard</a>
    <a href="/admin/create">+ Tulis Berita</a>
</div>

<table>
    <tr>
        <th>Judul</th>
        <th>Source</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    @foreach($articles as $article)
    <tr>
        <td>{{ $article->title }}</td>
        <td>{{ $article->source }}</td>
        <td>{{ $article->published_at }}</td>
        <td>

            <form method="POST" action="/admin/articles/delete/{{ $article->id }}">
                @csrf
                <button class="btn delete">Hapus</button>
            </form>

        </td>
    </tr>
    @endforeach

</table>

</body>
</html>