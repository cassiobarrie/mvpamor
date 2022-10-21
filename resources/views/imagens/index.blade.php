@extends('imagens.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Fotos</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('imagens.create') }}"> Adicionar nova Foto</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Detalhes</th>
            <th width="280px">Ação</th>
        </tr>
        @foreach ($imagens as $imagem)
        <tr>
            <td>{{ ++$i }}</td>
            <td><img src="/images/{{ $imagem->image }}" width="100px"></td>
            <td>{{ $imagem->name }}</td>
            <td>{{ $imagem->detail }}</td>
            <td>
                <form action="{{ route('imagens.destroy',$imagem->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('imagens.show',$imagem->id) }}">Visualizar</a>

                    <a class="btn btn-primary" href="{{ route('imagens.edit',$imagem->id) }}">Editar</a>

                    @csrf
                    @method('delete')

                    <button type="submit" class="btn btn-danger">Deletar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $imagens->links() !!}

@endsection
