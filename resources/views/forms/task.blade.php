@extends('layouts.site')

@if($task ?? '')
  @section('title', 'Editar tarefa')
@else
  @section('title', 'Criar nova tarefa')
@endif

@section('css')
  <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
@stop
@section('content')
<div class="row">
  <div class="col s12">
    @if($task ?? '')
      <h5>Editar tarefa</h5>
    @else
      <h5>Criar nova tarefa</h5>
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
    <div class="col s6 m3 l2 red-text">
      {{ session('danger') }}
    </div>
  </div>
  @endif

<div class="row">
  @if($task ?? '')
    <form role="form" action="{{ route('forms.task.update', $task->id) }}" method="POST">
    {{ method_field('PUT') }}
  @else
    <form role="form" action="{{ route('forms.task.store')  }}" method="POST">
  @endif
    @csrf
    <div class="input-field col s12">
      <input id="description" name="description" type="text" class="validate" value="{{ old('description',  $task->description ?? '') }}">
      <label for="description" class="input-label">Descrição</label>
    </div>
    <div class="col s12 m6 l3">
      @if($task ?? '')
        <label for="datetime_deadline" class="input-label">Data/Hora Prazo limite</label>
        <input disabled name="datetime_deadline_edit" class="datetime_edit" value="{{$task->datetime_deadline}}">
      @else
        <label for="datetime_deadline" class="input-label">Data/Hora Prazo limite</label>
        <input id="datetime_deadline" placeholder="" onblur="verifyDatetime()" type="datetime-local" name="datetime_deadline" class="datetime" value="{{ old('datetime_deadline',  $task->datetime_deadline ?? '') }}">
      @endif

    </div>
    <div class="col s12 m6 l3" >
      <label for="priority">Prioridade</label>
      <select name="priority" value="{{ old('priority',  $task->priority ?? '') }}">
        <option value="" disabled selected>Escolha a prioridade</option>
        <option value="Baixa" @if (old("priority", $task->priority ?? '') == "Baixa") selected @endif>Baixa</option>
        <option value="Média" @if (old("priority", $task->priority ?? '') == "Média") selected @endif>Média</option>
        <option value="Alta" @if (old("priority", $task->priority ?? '') == "Alta") selected @endif>Alta</option>
      </select>
    </div>
    <div class="col s12 m6 l3">
      <label for="datetime_completed" class="input-label">Data/Hora realizada</label>
      <input id="datetime_completed" type="datetime-local"  name="datetime_completed" type="text" class="validate" value="{{ old('datetime_completed',  $task->datetime_completed ?? '') }}">
    </div>
    <div class="input-field col s12 m6 l3">
      <label for="collaborator" class="input-label">Colaborador</label>
      @if($task ?? '')
      <input type="text" name="collaborator" placeholder="Procure por um colaborador" id="collaborator" class="autocomplete" value="{{ old('collaborator', '#'.$task->collaborator->id.'-'.$task->collaborator->name ?? '') }}">
      @else
      <input type="text" name="collaborator" placeholder="Procure por um colaborador" id="collaborator" class="autocomplete" value="{{ old('collaborator', $task->collaborator->name ?? '') }}">
      @endif
    </div>
    <div class="input-field col s12 right-align">
      <button class="btn waves-effect waves-light" type="submit" name="action">Criar
        <i class="material-icons right">send</i>
      </button>
    </div>

  </form>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.autocomplete');
    var collaborators = <?php echo json_encode($collaborators); ?>;

    var instances = M.Autocomplete.init(elems, {
      data: {
        @foreach($collaborators as $collaborator)
          "#{{ $collaborator->id }} - {{ $collaborator->name }}": null,
        @endforeach
      },
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {
      dropdownOptions: {
        container: document.body,
      },

    });
  });
  var dateTime = document.getElementById('datetime_deadline');
  var moment = moment();
  const dateTimeValue = moment.format('YYYY-MM-DDTHH:mm');

  dateTime.value = dateTimeValue;

  // dateTime.value = dateTimeValue;

function verifyDatetime() {
  var x = document.getElementById("datetime_deadline");
  var value = x.value;

  var diffHours = moment.diff(value, 'hours');
  var diffMinutes = moment.diff(value, 'minutes');
  console.log(diffHours);
  if (diffHours > -23 || diffHours === 0) {

    alert("Data/Hora Prazo limite deverá ser pelo menos 24 horas à frente da data/hora atual");
  }


}
</script>
<script>
</script>
@stop
