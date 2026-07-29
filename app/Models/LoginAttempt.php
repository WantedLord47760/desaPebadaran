<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    protected $table = 'login_attempts';

    protected $fillable = [
        'ip_address',
        'email',
        'attempts',
        'blocked_until',
    ];

    protected $casts = [
        'blocked_until' => 'datetime',
    ];

    public static function isBlocked($ip)
    {
        $attempt = self::where('ip_address', $ip)->first();
        if ($attempt && $attempt->blocked_until && $attempt->blocked_until > now()) {
            return true;
        }
        return false;
    }

    public static function recordAttempt($ip, $email)
    {
        $attempt = self::firstOrCreate(
            ['ip_address' => $ip],
            ['email' => $email, 'attempts' => 0]
        );

        $attempt->attempts += 1;
        $attempt->email = $email;
        
        if ($attempt->attempts >= 5) {
            $attempt->blocked_until = now()->addMinutes(15);
        }
        
        $attempt->save();
        return $attempt;
    }

    public static function reset($ip)
    {
        self::where('ip_address', $ip)->delete();
    }
}
