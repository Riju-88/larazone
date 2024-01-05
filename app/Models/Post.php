<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'category_id',
        'thread_id',
        'upvotes',
        'downvotes',
        'upvoted_by',
        'downvoted_by',
        'files',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    // Post.php

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

  // Define the relationships
public function userUpvoted()
{
    if ($this->upvoted_by && in_array(auth()->id(), json_decode($this->upvoted_by))) {
        // User has already upvoted this post
        return true;
    } else {
        // User has not upvoted this post
        return false;
    }
    
    
}

public function userDownvoted()
{
    if ($this->downvoted_by && in_array(auth()->id(), json_decode($this->downvoted_by))) {
        // User has already upvoted this post
        return true;
    } else {
        return false;
    }
}
    
public function getFilesAttribute($value)
{
    return json_decode($value, true);
}
    
// Thread.php




}
