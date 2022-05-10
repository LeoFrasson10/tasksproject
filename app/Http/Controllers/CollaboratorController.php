<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collaborator;
use App\Task;

class CollaboratorController extends Controller
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


      return view('collaborators', compact('collaborators'));
    }
    public function create()
    {
      return view('forms.collaborator');
    }

    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:collaborators',
        'cpf' => 'required|string',
      ],[
        'name.required' => 'O campo nome é obrigatório',
        'name.max' => 'O campo nome deve ter no máximo 255 caracteres',
        'email.required' => 'O campo email é obrigatório',
        'email.email' => 'O campo email deve ser um email válido',
        'email.max' => 'O campo email deve ter no máximo 255 caracteres',
        'email.unique' => 'O email informado já está cadastrado',
        'cpf.required' => 'O campo cpf é obrigatório',
      ]);
      $data = $request->all();
      $collaborator = Collaborator::create($data);
      if($collaborator){
        return redirect()->route('collaborators')->with('success', 'Colaborador cadastrado com sucesso!');
      } else{
        return redirect()->back()->with('danger', 'Erro ao cadastrar usuário!');
      }

      return view('tasks');
    }
    public function edit($id)
    {
      $collaborator = Collaborator::find($id);

      return view('forms.collaborator', compact('collaborator'));
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'cpf' => 'required|string',
      ],[
          'name.required' => 'O campo nome é obrigatório',
          'name.max' => 'O campo nome deve ter no máximo 255 caracteres',
          'cpf.required' => 'O campo cpf é obrigatório',
        ]);
      $data = $request->all();
      $collaborator = Collaborator::find($id);
      $collaborator->update($data);
      if($collaborator){
        return redirect()->route('collaborators')->with('success', 'Colaborador atualizado com sucesso!');
      } else{
        return redirect()->back()->with('danger', 'Erro ao atualizar usuário!');
      }
    }
    public function destroy($id)
    {
      $collaborator = Collaborator::find($id);
      $tasks = Task::where('collaborator_id', $id)->get();
      if ($tasks->count() > 0) {
        return redirect()->back()->with('danger', 'Não é possível excluir este colaborador, pois ele possui tarefas cadastradas!');
      }

      $collaborator->delete();
      if($collaborator){
        return redirect()->route('collaborators')->with('success', 'Colaborador excluído com sucesso!');
      } else{
        return redirect()->back()->with('danger', 'Erro ao excluir usuário!');
      }
    }
}
