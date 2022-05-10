@extends('layouts.site')

@section('title', $collaborator ?? '' ? 'Editar colaborador' : 'Criar novo colaborador')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
@stop
@section('content')
<div class="row">
  <div class="col s12">
    @if($collaborator ?? '')
      <h5>Editar colaborador: {{ $collaborator->name}}</h5>
    @else
      <h5>Criar novo colaborador</h5>
    @endif
  </div>
</div>
@if ($errors->any())
  <div class="row">
    <div class="col s12">
      <span>Erros: </span>
    </div>
    @foreach ($errors->all() as $error)
      <div class="col s6 m3 l2">
        <span class="red-text">{{ $error }}</span>
      </div>
    @endforeach
  </div>
  @endif
  @if(session('danger'))
  <div class="row">
    <div class="col s6 m3 l2">
      <span class="red-text">{{ session('danger') }}</span>
    </div>
  </div>
  @endif
<div class="row">
  @if($collaborator ?? '')
    <form role="form" action="{{ route('forms.collaborator.update', $collaborator->id) }}" method="POST">
    {{ method_field('PUT') }}
  @else
    <form method="POST" action="{{ route('forms.collaborator.store') }}">
  @endif
    @csrf
    <div class="input-field col s12 m6 l4">
      <input id="name" name="name" type="text" class="validate" value="{{ old('name',  $collaborator->name ?? '') }}">
      <label for="name" class="input-label">Nome</label>
    </div>
    <div class="input-field col s12 m6 l4">
      <input id="cpf" name="cpf" type="text" class="validate" value="{{ old('cpf',  $collaborator->cpf ?? '') }}">
      <label for="cpf" class="input-label">CPF</label>
    </div>
    <div class="input-field col s12 m6 l4">
      <input id="email" @if ($collaborator ?? '') disabled @endif name="email" type="email" class="validate" value="{{ old('email',  $collaborator->email ?? '') }}">
      <label for="email" class="input-label">E-mail</label>
    </div>
    <div class="input-field col s12 right-align">
      <button class="btn waves-effect waves-light" type="submit" name="action">Salvar
        <i class="material-icons right">send</i>
      </button>
    </div>

  </form>
</div>
@stop
@section('js')

<script>
  $(document).ready(function(){
    $('#cpf').inputmask({
      mask: ['999.999.999-99'],
      showMaskOnHover: false,
      showMaskOnFocus: false,
      // removeMaskOnSubmit: true,
    });
  });
  </script>
@stop
