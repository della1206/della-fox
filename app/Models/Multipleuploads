<?php
// app/Models/Multipleuploads.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multipleuploads extends Model
{
    use HasFactory;

    protected $table = 'multipleuploads';
    
    protected $fillable = [
        'filename',
        'ref_table',
        'ref_id',
    ];

    // Accessor untuk URL file
    public function getFileUrlAttribute()
    {
        return asset('uploads/' . $this->filename);
    }

    // Method untuk mendapatkan ekstensi file
    public function getFileExtensionAttribute()
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    // Method untuk cek apakah file adalah gambar
    public function getIsImageAttribute()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(strtolower($this->file_extension), $imageExtensions);
    }
}