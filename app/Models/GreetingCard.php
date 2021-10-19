<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GreetingCard extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'canvas_data', 'sender', 'recipient'
    ];

    /**
     * Get the recipient of the card.
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient', 'id');
    }

    /**
     * Get the sender of the card.
     */
    public function sender()
    {
        return $this->hasMany(User::class, 'id', 'sender');
    }
}
