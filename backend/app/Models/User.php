<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * 
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string|null $paternal_surname
 * @property string|null $maternal_surname
 * @property string|null $phone
 * @property string|null $address
 * @property bool $is_active
 * @property Carbon|null $last_login_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Appointment[] $appointments
 * @property Collection|AuditLog[] $audit_logs
 * @property Collection|ChatbotAlert[] $chatbot_alerts
 * @property Collection|ChatbotInteraction[] $chatbot_interactions
 * @property Collection|Comment[] $comments
 * @property Collection|File[] $files
 * @property Collection|ModelHasRole[] $model_has_roles
 * @property Collection|Notification[] $notifications
 * @property Collection|PostVote[] $post_votes
 * @property Collection|Post[] $posts
 * @property Professional|null $professional
 * @property Collection|QuestionnaireResponse[] $questionnaire_responses
 * @property Collection|Questionnaire[] $questionnaires
 * @property Collection|Resource[] $resources
 * @property Collection|Role[] $roles
 * @property StudentProfile|null $student_profile
 *
 * @package App\Models
 */
class User extends Model
{
	use SoftDeletes;
	protected $table = 'users';

	protected $casts = [
		'is_active' => 'bool',
		'last_login_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'email',
		'password',
		'name',
		'paternal_surname',
		'maternal_surname',
		'phone',
		'address',
		'is_active',
		'last_login_at',
		'remember_token'
	];

	public function appointments()
	{
		return $this->hasMany(Appointment::class, 'created_by');
	}

	public function audit_logs()
	{
		return $this->hasMany(AuditLog::class);
	}

	public function chatbot_alerts()
	{
		return $this->hasMany(ChatbotAlert::class, 'resolved_by');
	}

	public function chatbot_interactions()
	{
		return $this->hasMany(ChatbotInteraction::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function files()
	{
		return $this->hasMany(File::class, 'owner_user_id');
	}

	public function model_has_roles()
	{
		return $this->hasMany(ModelHasRole::class, 'assigned_by');
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}

	public function post_votes()
	{
		return $this->hasMany(PostVote::class);
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function professional()
	{
		return $this->hasOne(Professional::class);
	}

	public function questionnaire_responses()
	{
		return $this->hasMany(QuestionnaireResponse::class);
	}

	public function questionnaires()
	{
		return $this->hasMany(Questionnaire::class, 'created_by');
	}

	public function resources()
	{
		return $this->hasMany(Resource::class, 'validated_by');
	}

	public function roles()
	{
		return $this->hasMany(Role::class, 'created_by');
	}

	public function student_profile()
	{
		return $this->hasOne(StudentProfile::class);
	}
}