<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 *
 * @property int $id
 * @property string $owner_email
 * @property string $name
 * @property string|null $description
 * @property string|null $icon
 * @property string|null $color
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $owner
 * @property Collection|Pool[] $pools
 * @property Collection|ProjectMember[] $members
 * @property Collection|Tag[] $tags
 */
class Project extends Model
{
	protected $table = 'projects';

	protected $fillable = [
		'owner_email',
		'name',
		'description',
		'icon',
		'color',
		'status',
	];

	public function owner()
	{
		return $this->belongsTo(User::class, 'owner_email', 'email');
	}

	public function pools()
	{
		return $this->hasMany(Pool::class)->orderBy('position');
	}

	public function members()
	{
		return $this->hasMany(ProjectMember::class);
	}

	public function tags()
	{
		return $this->hasMany(Tag::class);
	}
}
