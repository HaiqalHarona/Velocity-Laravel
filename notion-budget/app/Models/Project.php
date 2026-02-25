<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * 
 * @property int $id
 * @property int $workspace_id
 * @property string $name
 * @property string|null $icon
 * @property string|null $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Workspace $workspace
 * @property Collection|Task[] $tasks
 *
 * @package App\Models
 */
class Project extends Model
{
	protected $table = 'projects';

	protected $casts = [
		'workspace_id' => 'int'
	];

	protected $fillable = [
		'workspace_id',
		'name',
		'description',
		'icon',
		'color',
		'visibility'
	];

	public function workspace()
	{
		return $this->belongsTo(Workspace::class);
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}

	public function projectMembers()
	{
		return $this->hasMany(ProjectMember::class);
	}
}
