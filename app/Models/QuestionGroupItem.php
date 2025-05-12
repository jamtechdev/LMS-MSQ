<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionGroupItem extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'question_id', 'sequence'];

    public function group()
    {
        return $this->belongsTo(QuestionGroup::class, 'group_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
