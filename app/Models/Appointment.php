<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orhpan_id',
        'user_id',
        'status',
        'date',
        'requirements',
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'orhpan_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function orphan()
    {
        return $this->belongsTo(Orphan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orhpan()
    {
        return $this->belongsTo(Orhpan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
