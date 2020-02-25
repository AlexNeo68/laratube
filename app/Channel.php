<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Channel extends Model implements HasMedia
{
    use HasMediaTrait;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function editable()
    {
        if (Auth::check()) {
            return $this->user_id === auth()->user()->id;
        }
        return false;
    }

    public function getImageAttribute()
    {
        $image = $this->getFirstMedia('images');
        return $image ? $image->getFullUrl('thumb') : null;
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('images')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
