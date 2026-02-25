<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Workspace
 * 
 * @property int $id
 * @property string $name
 * @property string $owner_email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Project[] $projects
 * @property Collection|Tag[] $tags
 * @property Collection|WorkspaceMember[] $workspace_members
 *
 * @package App\Models
 */
class Workspace extends Model
{
	protected $table = 'workspaces';

	protected $fillable = [
		'name',
		'owner_email'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'owner_email', 'email');
	}

	public function projects()
	{
		return $this->hasMany(Project::class);
	}

	public function tags()
	{
		return $this->hasMany(Tag::class);
	}

	public function workspace_members()
	{
		return $this->hasMany(WorkspaceMember::class);
	}
}
