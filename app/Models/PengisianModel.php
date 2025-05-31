<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengisianModel extends Model
{
    use HasFactory;

    protected $table = "m_pengisian";
    protected $primaryKey = "id_pengisian";
    protected $fillable = ['nama_pengisian'];

    public function detail(): HasMany
    {
        return $this->hasMany(DetailKriteriaModel::class, 'id_pengisian', 'id_pengisian');
    }
}
