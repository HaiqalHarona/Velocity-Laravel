<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * 
 * @property int $id
 * @property int $project_id
 * @property string $title
 * @property string|null $description
 * @property string|null $status
 * @property string|null $priority
 * @property Carbon|null $due_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Project $project
 * @property Collection|Comment[] $comments
 * @property Collection|TaskAssignee[] $task_assignees
 * @property Collection|Tag[] $tags
 *
 * @package App\Models
 */
class Task extends Model
{
	protected $table = 'tasks';

	protected $casts = [
		'project_id' => 'int',
		'due_date' => 'datetime'
	];

	protected $fillable = [
		'project_id',
		'title',
		'description',
		'status',
		'priority',
		'due_date'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function task_assignees()
	{
		return $this->hasMany(TaskAssignee::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class, 'task_tags');
	}
}
