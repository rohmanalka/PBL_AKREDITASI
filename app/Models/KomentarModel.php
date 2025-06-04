<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarModel extends Model
{
    use HasFactory;

    protected $table = "t_komentar";
    protected $primaryKey = "id_komentar";
    protected $fillable = ['komentar', 'id_user'];

    public function details(): HasMany
    {
        return $this->hasMany(DetailKriteriaModel::class, 'id_komentar', 'id_komentar');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }
}
