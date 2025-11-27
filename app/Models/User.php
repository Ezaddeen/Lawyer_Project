<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
        'is_active',
        'lawyer_id',
        'client_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


       public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // -----------------------------
    // العلاقات (Relationships)
    // -----------------------------

    public function courtChanges()
    {
        return $this->hasMany(CourtChange::class, 'modifed_by');
    }

    public function caseAmendments()
    {
        return $this->hasMany(CaseAmendment::class, 'modified_by');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }

    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class, 'reviewer_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function workflows()
    {
        return $this->hasMany(Workflow::class, 'assigned_user_id');
    }

    public function logalAssistantBots()
    {
        return $this->hasMany(LogalAssistantBot::class);
    }

    public function adminAgentBots()
    {
        return $this->hasMany(AdminAgentBot::class, 'admin_user_id');
    }

    public function botFeedbaks()
    {
        return $this->hasMany(BotFeedbak::class);
    }
}
