<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $cover_image
 * @property int $id
 * @property string $book_image_path
 * @property string $title
 * @property string $summary
 * @property Collection $chapters
 */
class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'book_image_path',
        'completed_at_formatted',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected function completedAtFormatted(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if (! data_get($attributes, 'completed_at')) {
                    return null;
                }

                return Carbon::parse($attributes['completed_at'])->toFormattedDateString();
            }
        );
    }

    /**
     * get BookImagePath Attribute
     * book_image_path
     */
    public function getBookImagePathAttribute()
    {
        if (! $this->cover_image) {
            $subTitle = str($this->title)->substr(0, 1)
                ->upper()
                ->toString();

            return sprintf('https://ui-avatars.com/api/?name=%s&color=7F9CF5&background=EBF4FF',
                $subTitle
            );
        }

        return $this->cover_image;
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
