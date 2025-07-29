<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'name',
        'is_group',
    ];

    public function isDirect()
    {
        return !$this->is_group && $this->participants()->count() === 2;
    }
    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withTimestamps()
                    ->withPivot('role');
    }
}
