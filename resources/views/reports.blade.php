<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Reporte de articulos</title>
</head>
<body>

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-12">

                <h3>Reporte</h3>

                <table class="table">

                    <thead>
                        <tr>
                            <th>Codigo de registro</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Categoria</th>
                            <th>Fecha de creacion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>{{ $article->register_number }}</td>
                                <td>{{ $article->name }}</td>
                                <td>{{ $article->quantity }}</td>
                                <td>{{ $article->category->name }}</td>
                                <td>{{ $article->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>
</html>
