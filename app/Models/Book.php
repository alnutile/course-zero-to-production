<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * get BookImagePath Attribute
     * book_image_path
     */
    public function getBookImagePathAttribute() {

        return "https://ui-avatars.com/api/?name=a&color=7F9CF5&background=EBF4FF";
    }
}
