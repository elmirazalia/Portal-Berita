<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f6fa;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .box {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #2c3e50;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h1>Dashboard Admin</h1>

<div class="box">
    <h3>Total Artikel</h3>
    <p>{{ $totalArtikel }}</p>
</div>

<div class="box">
    <h3>Total User</h3>
    <p>{{ $totalUser }}</p>
</div>

<a href="/" class="btn">← Kembali ke Portal</a>
<a href="/admin/create" class="btn">+ Tulis Berita</a>
<a href="/admin/articles" class="btn">Kelola Artikel</a>
<a href="/admin/users" class="btn">Manajemen User</a>

</body>
</html>