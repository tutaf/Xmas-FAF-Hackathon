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
        'image_id',
        'user_id',
        'location',
        'text',
    ];

    protected $casts = [
        'user_id' => 'int',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orphans()
    {
        return $this->hasMany(Orphan::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
