<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function threads()
{
    return $this->hasMany(Thread::class);
}

public function subscribers()
{
    return $this->belongsToMany(User::class, 'subscriptions');
}

public function subscriptions()
{
    return $this->hasMany(Subscription::class);
}
}
