<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrphanBuilding extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'image',
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orphans()
    {
        return $this->hasMany(Orphan::class);
    }
}
