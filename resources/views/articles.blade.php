<div>
    <table>
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Photo</th>
            <th>Auteur</th>
            <th>Content</th>
        </tr>
        <tr>
            @foreach ( $articles as $articless )
              <td>{{$articless->title}}</td>
              <td>{{$articless->slug}}</td>
              <td>{{$articless->photo}}</td>
              <td>{{$articless->auteur}}</td>
              <td>{{$articless->content}}</td>
              <br>
            @endforeach
            
        </tr>
    </table>
</div>
