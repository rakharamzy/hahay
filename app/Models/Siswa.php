<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    protected $table = 'siswa';
    public $timestamps =false;
    //untuk relasi eloquent
    public function pelanggaran():HasMany
{
        return $this->hasMany(Pelanggaran::class,'nis','nis');
}
}
