<?php

namespace App\Models\App;

use App\Models\Authentication\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $table = 'app.patients';

    protected $cascadeDeletes = ['clinicalHistories','treatments'];

    protected $fillable = [
        'code',
        'description',
        'name',
        'type',
    ];

    // Relationships
    public function clinicalHistories()
    {
        return $this->hasMany(ClinicalHistory::class);
    }

    public function sector()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mutators
    public function scopeCustomOrderBy($query, $sorts)
    {
        if (!empty($sorts[0])) {
            foreach ($sorts as $sort) {
                $field = explode('-', $sort);
                if (empty($field[0]) && in_array($field[1], $this->fillable)) {
                    $query = $query->orderByDesc($field[1]);
                } else if (in_array($field[0], $this->fillable)) {
                    $query = $query->orderBy($field[0]);
                }
            }
            return $query;
        }
    }

    public function scopeUser($query, $search)
    {
        if ($search) {
            return $query->whereHas('user', function ($user) use ($search) {
                $user->where('name', 'iLike', "%$search%")
                    ->orWhere('lastname', 'iLike', "%$search%");
            });
        }
    }
}
