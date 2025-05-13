<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'label', 'value', 'is_correct',];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
