@extends('layouts.site')

@section('title', 'Lista de colaboradores')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
@stop
@section('content')
    <div class="row">
      <div class="col s6">
        <h5>Lista de colaboradores</h5>
      </div>
      <div class="col s6 right-align">
        <a href="{{ route('forms.collaborator') }}" class="waves-effect waves-light btn-small"><i class="material-icons left">add</i>Novo colaborador</a>
      </div>
    </div>
    @if(session('success'))
      <div class="row">
        <div class="col s12">
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        </div>
      </div>
      @endif
      @if(session('danger'))
      <div class="row">

        <div class="col s12">
          <div class="alert alert-danger">
            {{ session('danger') }}
          </div>
        </div>
      </div>
      @endif
    <div class="row">
      <div class="col s12">
        <table class="highlight centered">
          <thead class="teal lighten-5">
            <tr>
              <th>Cód.</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>E-mail</th>
              <th>Ações</th>
            </tr>
          </thead>

          <tbody>
            @if(count($collaborators) === 0)
              <tr>
                <td colspan="6">Nenhum  colaborador cadastrado</td>
              </tr>
            @else
              @foreach($collaborators as $collaborator)
                <tr>
                  <td>#{{ $collaborator->id }}</td>
                  <td>{{ $collaborator->name }}</td>
                  <td>{{ $collaborator->cpf }}</td>
                  <td>{{ $collaborator->email }}</td>
                  <td class="actions">
                    <a href="{{ route('forms.collaborator.edit', ['id' => $collaborator->id]) }}" class="btn "><i class="material-icons left">edit</i>Editar</a>

                    <form action="{{ route('forms.collaborator.destroy', ['id' => $collaborator->id]) }}" method="POST">
                      @csrf
                      @method('delete')
                      <button type="submit" class="btn"><i class="material-icons left">delete</i>Excluir</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif

          </tbody>
        </table>
      </div>
    </div>
@stop
@section('js')
@stop

