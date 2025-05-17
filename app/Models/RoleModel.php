<?php

namespace App\Models;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = "m_role";
    protected $primaryKey = "id_role";
    protected $fillable = ['id_kriteria', 'role_kode', 'role_name'];

    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
    }
}
