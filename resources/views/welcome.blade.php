<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>
    <body class="antialiased">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding: 20px">
                <form method="POST" action="{{ route('crawler') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="First name">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn btn-primary">Crawler</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Image</th>
                    <th scope="col">Category</th>
                    <th scope="col">Comment Count</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->image }}</td>
                    <td>{{ $post->category }}</td>
                    <td>{{ $post->comment_count }}</td>
                    <td><a href="{{ route('export-pdf', ['id' => $post->id]) }}">Export PDF</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </body>
</html>
