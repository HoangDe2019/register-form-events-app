<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'user_id',
        'event_type_id',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function eventHasOneUser()
    {
        return $this->hasOne(__NAMESPACE__ . '\user', 'id', 'user_id');
    }

    public function eventHasOneEventType()
    {
        return $this->hasOne(__NAMESPACE__ . '\event_types', 'id', 'event_type_id');
    }
}
