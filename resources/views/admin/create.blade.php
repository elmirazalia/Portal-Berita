<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tulis Berita</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f5f7fb;
    font-family:Arial, Helvetica, sans-serif;
}

.container{
    width:800px;
    margin:40px auto;
}

.back{
    text-decoration:none;
    color:#888;
    font-size:13px;
}

.card{
    background:white;
    margin-top:15px;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 12px rgba(0,0,0,.05);
}

h1{
    margin-bottom:25px;
}

.form-group{
    margin-bottom:15px;
}

input[type=text],
input[type=url],
textarea{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:4px;
    font-size:14px;
}

textarea{
    resize:vertical;
}

label{
    display:block;
    margin-bottom:5px;
    font-weight:bold;
    color:#444;
}

input:focus,
textarea:focus{
    outline:none;
    border-color:#2563eb;
}

.upload-box{
    border:2px dashed #ccc;
    padding:20px;
    text-align:center;
    border-radius:6px;
    background:#fafafa;
}

.btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 22px;
    border-radius:6px;
    cursor:pointer;
    font-size:15px;
}

.btn:hover{
    background:#1d4ed8;
}

.ck-editor__editable{
    min-height:350px;
}
</style>

{{-- CKEDITOR --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

</head>
<body>

<div class="container">

    <a href="/dashboard" class="back">
        ← Kembali
    </a>

    <div class="card">

        <h1>Tulis Berita</h1>

        <form
            action="/admin/store"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <input
                    type="text"
                    name="title"
                    placeholder="Judul Berita"
                    required
                >
            </div>

            <div class="form-group">
                <input
                    type="url"
                    name="original_link"
                    placeholder="Link Sumber Berita (opsional)"
                >
            </div>

            <div class="form-group">
                <textarea
                    name="description"
                    rows="4"
                    placeholder="Deskripsi Singkat"
                ></textarea>
            </div>

            <div class="form-group">
                <label>Isi Berita</label>

                <textarea
                    id="editor"
                    name="content"
                ></textarea>
            </div>

            <div class="form-group">
                <label>Upload Gambar</label>

                <div class="upload-box">
                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                    >
                </div>
            </div>

            <button class="btn">
                Simpan Berita
            </button>

        </form>

    </div>

</div>

<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>

</body>
</html>