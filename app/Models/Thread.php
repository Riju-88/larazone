<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;
class Thread extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content','files',]; // Add 'title' to the fillable fields.

    public function posts()
{
    return $this->hasMany(Post::class);
}

public function category()
{
    return $this->belongsTo(Category::class);
}

// Add a mutator to decode the JSON data when accessing it
public function getFilesAttribute($value)
{
    return json_decode($value, true);
}

public function user()
{
    return $this->belongsTo(User::class);
}
// Thread.php





}
