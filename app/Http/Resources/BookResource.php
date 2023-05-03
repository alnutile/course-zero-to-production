<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'book_image_path' => $this->book_image_path,
            'cover_image' => $this->cover_image,
            'summary' => ($this->summary) ?? 'No summary write one!',
            'owner' => $this->owner,
            'chapters' => $this->chapters,
        ];
    }
}
