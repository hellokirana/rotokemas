<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $table = 'news';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'content',
        'link',
        'link_thumbnail',
        'featured',
        'image_path',
        'document_path',
        'audience',
    ];

    protected static function boot()
    {
        parent::boot();

        // Buat UUID secara otomatis saat membuat entri baru
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title . '-' . Str::random(6));
            }
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
