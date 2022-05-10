<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Collaborator;

class TaskController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $collaborators = Collaborator::all();
      $collaborator = $request->get('collaborator');
      $priority = $request->get('priority');
      $datetime = $request->get('datetime_deadline');


      $letters = array('#', " ");
      $collaboratorId = explode('-', str_replace($letters, '', $collaborator));
      $collaboratorFind = Collaborator::find($collaboratorId[0]);



      if(!empty($priority) && !empty($datetime) && !empty($collaboratorFind)){
        $tasks = Task::sortable()->where('collaborator_id', $collaboratorFind->id)->where('priority', $priority)->where('datetime_deadline', '<=', $datetime)->get();
      } elseif(!empty($collaboratorFind) && !empty($priority) && !empty($datetime)){
        $tasks = Task::sortable()->where('collaborator_id', $collaboratorFind->id)->where('priority', $priority)->where('datetime_deadline', '<=', $datetime)->get();
      } elseif(!empty($collaboratorFind) && !empty($priority)){
        $tasks = Task::sortable()->where('collaborator_id', $collaboratorFind->id)->where('priority', $priority)->get();
      } elseif(!empty($collaboratorFind) && !empty($datetime)){
        $tasks = Task::sortable()->where('collaborator_id', $collaboratorFind->id)->where('datetime_deadline', $datetime)->get();
      } elseif(!empty($priority) && !empty($datetime)){
        $tasks = Task::sortable()->where('priority', $priority)->where('datetime_deadline', '<=', $datetime)->get();
      } elseif(!empty($collaboratorFind)){
        $tasks = Task::sortable()->where('collaborator_id', $collaboratorFind->id)->get();
      } elseif(!empty($priority)){
        $tasks = Task::sortable()->where('priority', $priority)->get();
      } elseif(!empty($datetime)){
        $tasks = Task::sortable()->where('datetime_deadline', '<=', $datetime)->get();
      } else{
        $tasks = Task::sortable()->with('collaborator')->orderBy('priority', 'desc')->get();
      }

      return view('tasks', compact('tasks', 'collaborator', 'collaborators','priority','datetime'));
    }

    public function create()
    {
      $collaborators = Collaborator::all();

      return view('forms.task', compact('collaborators'));
    }

    public function store(Request $request)
    {
      $request->validate([
        'description' => 'required|string',
        'collaborator' => 'required|string',
        'priority' => 'required|string',
      ],[
        'description.required' => 'O campo descrição é obrigatório',
        'priority.required' => 'O campo prioridade é obrigatório',
        'collaborator.required' => 'O campo colaborador é obrigatório',
      ]);

      $data = $request->all();
      // replace
      $letters = array('#', " ");
      $collaboratorId = explode('-', str_replace($letters, '', $data['collaborator']));
      $collaborator = Collaborator::find($collaboratorId[0]);
      $datevalue = date('Y-m-d H:m', strtotime($data['datetime_deadline']));
      $dateNow = date('Y-m-d H:m');
      $dateNowAdd = date('Y-m-d H:m', strtotime('+24 hour', strtotime($dateNow)));

      if($datevalue < $dateNow){
        return redirect()->back()->with('danger', 'Data de término não pode ser menor que a data atual');
      }
      if ($dateNowAdd > $datevalue) {
        return redirect()->back()->with('danger', 'Data/Hora Prazo limite deverá ser pelo menos 24 horas à frente da data/hora atual');
      }
      if ($collaborator) {
        // dd($data);
        $task = new Task();
        $task->description = $data['description'];
        $task->collaborator_id = $collaborator->id;
        $task->priority = $data['priority'];
        $task->datetime_deadline = $data['datetime_deadline'];
        $task->datetime_completed = $data['datetime_completed'] ? $data['datetime_completed'] : null;
        $task->save();
        // dd($collaborator);
        // $data['collaborator_id'] = $collaboratorId[0];
        // $data['priority'] = $collaborator->priority;
        // $data['datetime_deadline'] = $collaborator->datetime_deadline;
        // $data['datetime_completed'] = null;
        // $task = Task::create($data);
        if($task){
          return redirect()->route('tasks')->with('success', 'Tarefa cadastrada com sucesso!');
        } else{
          return redirect()->back()->with('danger', 'Erro ao cadastrar tarefa!');
        }
      } else {
        return redirect()->back()->with('danger', 'Colaborador não encontrado!');
      }

    }

    public function edit($id)
    {
      $task = Task::find($id);
      $collaborators = Collaborator::all();
      return view('forms.task', compact('task', 'collaborators'));
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'description' => 'required|string',
        'collaborator' => 'required|string',
        'priority' => 'required|string',
      ],[
        'description.required' => 'O campo descrição é obrigatório',
        'priority.required' => 'O campo prioridade é obrigatório',
        'collaborator.required' => 'O campo colaborador é obrigatório',
      ]);

      $data = $request->all();
      // replace
      $letters = array('#', " ");
      $collaboratorId = explode('-', str_replace($letters, '', $data['collaborator']));
      $collaborator = Collaborator::find($collaboratorId[0]);
      if ($collaborator) {
        $task = Task::find($id);
        $task->description = $data['description'];
        $task->collaborator_id = $collaborator->id;
        $task->priority = $data['priority'];
        $task->datetime_completed = $data['datetime_completed'] ? $data['datetime_completed'] : null;
        $task->save();

        if($task){
          return redirect()->route('tasks')->with('success', 'Tarefa atualizada com sucesso!');
        } else{
          return redirect()->back()->with('danger', 'Erro ao atualizar tarefa!');
        }
      } else {
        return redirect()->back()->with('danger', 'Colaborador não encontrado!');
      }
    }

    public function destroy($id)
    {
      $task = Task::find($id);
      $task->delete();

      if($task){
        return redirect()->route('tasks')->with('success', 'Tarefa deletada com sucesso!');
      } else{
        return redirect()->back()->with('danger', 'Erro ao excluir Tarefa!');
      }
    }

}
