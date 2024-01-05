<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'category_id', 'thread_id', 'user_id', 'post_id','files'];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function getFilesAttribute($value)
{
    return json_decode($value, true);
}

public function thread()
{
    return $this->belongsTo(Thread::class);
}

public function post()
{
    return $this->belongsTo(Post::class);
}
// Thread.php

public function category()
{
    return $this->belongsTo(Category::class);
}


}
