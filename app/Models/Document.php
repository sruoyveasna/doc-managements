<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author_name',
        'publication_year',
        'keywords',
        'field_id',
        'genre_id',
        'status',
        'file_path',
        'uploaded_by',
    ];




    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
