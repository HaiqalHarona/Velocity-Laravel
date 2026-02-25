<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkspaceMember
 * 
 * @property int $id
 * @property int $workspace_id
 * @property string $user_email
 * @property string|null $role
 * @property Carbon|null $joined_at
 * 
 * @property Workspace $workspace
 * @property User $user
 *
 * @package App\Models
 */
class WorkspaceMember extends Model
{
	protected $table = 'workspace_members';
	public $timestamps = false;

	protected $casts = [
		'workspace_id' => 'int',
		'joined_at' => 'datetime'
	];

	protected $fillable = [
		'workspace_id',
		'user_email',
		'role',
		'joined_at'
	];

	public function workspace()
	{
		return $this->belongsTo(Workspace::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_email', 'email');
	}
}
