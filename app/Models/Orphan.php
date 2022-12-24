<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orphan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orphan_building_id',
        'firstName',
        'lastName',
        'birthday',
        'image_id',
        'text',
    ];

    public function orphanBuilding()
    {
        return $this->belongsTo(OrphanBuilding::class);
    }

    public function image()
    {
        return $this->hasMany(Image::class, 'id', 'image_id');
    }
}
