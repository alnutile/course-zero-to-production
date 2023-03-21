<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $appends = [
        'book_image_path'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * get BookImagePath Attribute
     * book_image_path
     */
    public function getBookImagePathAttribute() {
        if(!$this->cover_image) {
            $subTitle = str($this->title)->substr(0, 1)
                ->upper()
                ->toString();
            return sprintf("https://ui-avatars.com/api/?name=%s&color=7F9CF5&background=EBF4FF",
            $subTitle
            );
        }

        return $this->cover_image;
    }
}
