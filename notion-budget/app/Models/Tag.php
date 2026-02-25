<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * 
 * @property int $id
 * @property int $workspace_id
 * @property string $name
 * @property string|null $color
 * 
 * @property Workspace $workspace
 * @property Collection|Task[] $tasks
 *
 * @package App\Models
 */
class Tag extends Model
{
	protected $table = 'tags';
	public $timestamps = false;

	protected $casts = [
		'workspace_id' => 'int'
	];

	protected $fillable = [
		'workspace_id',
		'name',
		'color'
	];

	public function workspace()
	{
		return $this->belongsTo(Workspace::class);
	}

	public function tasks()
	{
		return $this->belongsToMany(Task::class, 'task_tags');
	}
}
