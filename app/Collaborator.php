<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
  protected $fillable = ['name', 'email', 'cpf'];

  public function tasks()
  {
    return $this->hasMany(Task::class, 'collaborator_id');
  }
}
