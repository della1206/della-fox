<?php
// app/Models/Pelanggan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';
    
    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'email',
        'phone',
    ];

    // Relasi ke multipleuploads
    public function files()
    {
        return $this->hasMany(Multipleuploads::class, 'ref_id', 'pelanggan_id')
                    ->where('ref_table', 'pelanggan');
    }

    // Accessor untuk nama lengkap
    public function getNamaLengkapAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}