<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    /**
     * Get the comments for the blog post.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', "id");
    }
}
