<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username', // PENTING: Jangan dihapus, ini buat nyimpen NISN
        'password',
        'role', 
        'guru_id',  // Ini buat nyimpen data guru walinya
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi untuk menghitung pesan yang diterima (untuk dashboard Admin)
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Relasi untuk pesan yang dikirim (opsional, buat jaga-jaga)
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // ==========================================
    // TAMBAHAN RELASI GURU WALI & ANAK ASUH
    // ==========================================

    /**
     * Relasi: Murid punya satu Guru Wali
     */
    public function guruWali()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Relasi: Guru punya banyak anak asuh (murid)
     */
    public function anakAsuh()
    {
        return $this->hasMany(User::class, 'guru_id');
    }
}