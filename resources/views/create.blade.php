<!DOCTYPE html>
<html>
<head>
    <title>Tulis Berita</title>

    <!-- CKEditor CDN (Gratis tanpa API key) -->
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        }

        h1 {
            margin-bottom: 30px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            background: #2c3e50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #1a252f;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .back {
            text-decoration: none;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="top-bar">
        <a href="/" class="back">← Kembali</a>
    </div>

    <h1>Tulis Berita</h1>

    <form method="POST" action="/admin/store">
        @csrf

        <input type="text" name="title" placeholder="Judul Berita..." required>

        <input type="text" name="image" placeholder="URL Gambar (opsional)">

        <textarea name="description" placeholder="Deskripsi Singkat..."></textarea>

        <textarea name="content" id="editor" placeholder="Tulis isi berita lengkap di sini..."></textarea>

        <button type="submit">Publish</button>
    </form>

</div>

<script>
    CKEDITOR.replace('editor', {
        height: 400
    });
</script>

</body>
</html>