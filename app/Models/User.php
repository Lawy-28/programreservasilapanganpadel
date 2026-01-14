<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',     // Nama user
        'email',    // Email login
        'password', // Password (akan dienkripsi)
        'role',     // Peran user: admin/staff
    ];

    /**
     * The attributes that should be hidden for serialization.
     * Kolom ini tidak akan muncul jika data user dikonversi ke JSON/Array
     */
    protected $hidden = [
        'password',       // Sembunyikan password agar aman
        'remember_token', // Token remember me juga rahasia
    ];

    /**
     * Get the attributes that should be cast.
     * Mengubah tipe data kolom secara otomatis saat diakses
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Dianggap sebagai objek tanggal
            'password' => 'hashed',            // Otomatis hash saat di-set (Fitur Laravel baru)
        ];
    }

    // Definisi konstanta untuk peran agar konsisten dan menghindari typo string 'admin'/'staff'
    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';

    /**
     * Check if user is admin.
     * Helper function untuk memudahkan pengecekan di controller/view.
     * Contoh penggunaan: if ($user->isAdmin()) { ... }
     */
    public function isAdmin(): bool // : bool artinya fungsi ini WAJIB mengembalikan True/False
    {
        return $this->role === self::ROLE_ADMIN; // Cek apakah kolom role nilainya sama dengan konstanta admin
    }

    /**
     * Check if user is staff.
     */
    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }
}
