<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Task extends Model
{
  use Sortable;

  protected $table = 'tasks';

  protected $fillable = ['description', 'datetime_deadline', 'collaborator_id', 'priority', 'datetime_completed', 'created_at'];

  public $sortable = ['id', 'priority', 'datetime_deadline', 'datetime_completed', 'created_at'];

  public function collaborator()
  {
    return $this->belongsTo(Collaborator::class, 'collaborator_id');
  }

}
