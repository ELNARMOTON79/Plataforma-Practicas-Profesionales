<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bitacora extends Model
{
    protected $table = 'bitacora';

    protected $appends = [
        'user_avatar_bg',
        'user_avatar_txt',
        'time_ago'
    ];

    protected $fillable = [
        'timestamp',
        'level',
        'level_name',
        'user',
        'user_role',
        'user_email',
        'module',
        'action',
        'description',
        'ip',
        'user_agent',
        'payload'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'timestamp' => 'datetime',
    ];

    /**
     * Accessor for user avatar background and text color Tailwind classes.
     */
    public function getUserAvatarBgAttribute(): string
    {
        $role = strtolower(trim($this->user_role));

        switch ($role) {
            case 'administrador':
                return 'bg-red-100 text-red-600';
            case 'coordinador':
                return 'bg-blue-100 text-blue-600';
            case 'alumno':
            case 'estudiante':
                return 'bg-purple-100 text-purple-600';
            case 'empresa':
                return 'bg-yellow-100 text-yellow-600';
            case 'sistema':
            default:
                return 'bg-gray-100 text-gray-600';
        }
    }

    /**
     * Accessor for user avatar initials (maximum 2 characters).
     */
    public function getUserAvatarTxtAttribute(): string
    {
        $name = trim($this->user);
        
        if (empty($name)) {
            return 'SY';
        }

        // If name is an email, extract initials from the username part
        if (filter_var($name, FILTER_VALIDATE_EMAIL)) {
            $username = explode('@', $name)[0];
            return strtoupper(substr($username, 0, 2));
        }

        // Split by whitespace
        $words = preg_split('/\s+/', $name);
        
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($name, 0, 2));
    }

    /**
     * Accessor for localized friendly time difference (Spanish).
     */
    public function getTimeAgoAttribute(): string
    {
        $date = Carbon::parse($this->timestamp)->locale('es');
        
        if ($date->isToday()) {
            $diffInMinutes = $date->diffInMinutes();
            if ($diffInMinutes < 1) {
                return 'Justo ahora';
            }
            if ($diffInMinutes < 60) {
                return "Hace {$diffInMinutes} min";
            }
            $diffInHours = $date->diffInHours();
            return "Hace {$diffInHours} " . ($diffInHours == 1 ? 'hora' : 'horas');
        }
        
        if ($date->isYesterday()) {
            return 'Ayer';
        }

        return $date->diffForHumans();
    }
}
