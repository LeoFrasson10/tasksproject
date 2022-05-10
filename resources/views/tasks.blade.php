@extends('layouts.site')

@section('title', 'Lista de tarefas')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
@stop
@section('content')
    <div class="row">
      <div class="col s6">
        <h5>Lista de tarefas</h5>
      </div>


      <div class="col s6 right-align">
        <a href="{{ route('forms.task') }}" class="waves-effect waves-light btn-small"><i class="material-icons left">add</i>Nova tarefa</a>
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
        <form autocomplete="off" method="GET">
          <div class="row container-search">
            <div class="col s12 m6 l3">
              <label for="collaborator" class="input-label">Colaborador</label>
              <input type="text" name="collaborator" placeholder="Procure por um colaborador" id="collaborator" class="autocomplete" value="{{$collaborator}}">
            </div>
            <div class="col s12 m6 l3" >
              <label for="priority">Prioridade</label>
              <select name="priority" value="{{$priority}}">
                <option value="" disabled selected>Escolha a prioridade</option>
                <option value="Baixa" @if (old("priority", $priority ?? '') == "Baixa") selected @endif>Baixa</option>
                <option value="Média" @if (old("priority", $priority ?? '') == "Média") selected @endif>Média</option>
                <option value="Alta" @if (old("priority", $priority ?? '') == "Alta") selected @endif>Alta</option>
              </select>
            </div>
            <div class="col s12 m6 l3">
              <label for="datetime_deadline" class="input-label">Data/Hora Prazo limite</label>
              <input id="datetime_deadline" placeholder="" type="datetime-local" name="datetime_deadline" class="datetime" value="{{$datetime}}">
            </div>
            <div class="col s12 m6 l3">
              <button type="submit" class="btn btn-default mb-2 blue"><i class="material-icons left">search</i>Procurar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col s12">
        <table class="highlight centered">
          <thead class="teal lighten-5">
            <tr>
              <th>@sortablelink('id','Cód.')</th>
              <th>Descrição</th>
              <th>Responsável</th>
              <th>@sortablelink('priority', 'Prioridade')</th>
              <th>@sortablelink('created_at', 'Data/Hora de cadastro')</th>
              <th>@sortablelink('datetime_deadline', 'Data/Hora Prazo limite')</th>
              <th>@sortablelink('datetime_completed', 'Data/Hora realizada')</th>
              <th>Ações</th>
            </tr>
          </thead>

          <tbody>
            @if(count($tasks) === 0)
              <tr>
                <td colspan="8" class="center-align">Nenhuma tarefa cadastrada</td>
              </tr>
            @else
              @foreach($tasks as $task)
                <tr>
                  <td>#{{ $task->id }}</td>
                  <td>{{ $task->description }}</td>
                  <td>{{ $task->collaborator->name }}</td>
                  <td>{{ $task->priority }}</td>
                  <td>{{ date('d/m/Y H:i', strtotime($task->created_at )) }}</td>
                  <td>{{ date('d/m/Y H:i', strtotime($task->datetime_deadline)) }}</td>
                  <td>{{ $task->datetime_completed ? date('d/m/Y H:i', strtotime($task->datetime_completed)) : 'Não realizada' }}</td>
                  <td class="actions">

                    <a href="{{ route('forms.task.edit', ['id' => $task->id]) }}" class="btn "><i class="material-icons left">edit</i>Editar</a>
                    <form action="{{ route('forms.task.destroy', ['id' => $task->id]) }}" method="POST">
                      @csrf
                      @method('delete')
                      <button type="submit" class=" btn"><i class="material-icons left">delete</i>Excluir</button>
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
</script>
@stop
