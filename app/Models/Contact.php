<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'last_name', 'email', 'phone'
    ];

    protected $casts = [
        'phone'     => 'integer'
    ];

    public function Messages(){
        return $this->hasMany(Message::class);
    }

    public function authorize(Message $message){
        return $this->id == $message->contact_id;
    }
}
