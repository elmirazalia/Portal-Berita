<!DOCTYPE html>
<html>
<head>
    <title>Manajemen User</title>

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

        .top {
            margin-bottom: 20px;
        }

        .btn {
            padding: 6px 10px;
            border-radius: 5px;
            background: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }

        select {
            padding: 5px;
        }
    </style>
</head>
<body>

<h1>Manajemen User</h1>

<div class="top">
    <a href="/admin/dashboard">← Dashboard</a>
</div>

<table>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>

        <td>
            @if($user->role == 'admin')
                <b style="color:green;">Admin</b>
            @else
                User
            @endif
        </td>

        <td>
            <form method="POST" action="/admin/users/{{ $user->id }}/role">
                @csrf

                <select name="role">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                        User
                    </option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>

                <button class="btn">Update</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

</body>
</html>