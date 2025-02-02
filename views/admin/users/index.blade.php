<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>{{ $title }}</h1>

    <ul>
        @foreach ($data as $user)
            <li>{{ $user['id'] . ' - ' . $user['name'] . ' - ' . $user['email'] }}</li>
        @endforeach
    </ul>

    @if (isset($_SESSION['msg']))
        <h2>{{ $_SESSION['msg'] }}</h2>
    @endif

    <form action="/admin/users/testUploadFile" method="POST" enctype="multipart/form-data">
        <label for="avatar">Choose avatar:</label>
        <input type="file" name="avatar" id="avatar" required>
        <br><br>
        <button type="submit">Upload</button>
    </form>
</body>

</html>
