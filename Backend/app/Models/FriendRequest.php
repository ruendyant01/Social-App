<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    public static function booted() : void {
        static::creating(function(FriendRequest $frq) {
            $frq->status = "Pending";
        });
    }

    protected $fillable = ['requestor', "to", "status"];
}
