<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['reporter_id', 'content_id', 'content_type', 'reason', 'creator_id'];

    // Report.php

// public function reported()
// {
//     return $this->morphTo();
// }
public function reporter()
{
    return $this->belongsTo(User::class, 'reporter_id');
}

}
