<style>
    h1{
        text-align: center;
        font-size: 40px;
        color: #333;
        text-decoration: underline;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        margin:  10px 15px;
    }
</style>

<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<div>
    <h1>Liste Articles</h1>
    <table>
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Photo</th>
            <th>Auteur</th>
            <th>Content</th>
        </tr>
        @foreach ($articles as $articless)
        <tr>
              <td>{{$articless->title}}</td>
              <td>{{$articless->slug}}</td>
              <td>{{$articless->photo}}</td>
              <td>{{$articless->auteur}}</td>
              <td>{{$articless->content}}</td>
        </tr>
        @endforeach
    </table>
</div>
