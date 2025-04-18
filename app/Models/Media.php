<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Media extends Model
{
    use HasUuids, Sluggable;
    protected $table = 'medias';
    protected $fillable = [
        'kategori_id',
        'image',
        'title',
        'slug',
        'konten',
        'caption',
        'penulis',
        'featured',
        'status',
        'published_at',
    ];
    protected $dates = ['published_at'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/media') . '/' . $this->image : 'https://loremflickr.com/800/600';
    }

    public function getStatusTextAttribute()
    {
        $status = status_active();
        return isset($status[$this->status]) ? $status[$this->status] : '';
    }

    public function kategori(): belongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
