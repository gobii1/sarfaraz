<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Tambahkan ini untuk membuat slug

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description', // Opsional, untuk SEO
        'meta_keywords',    // Opsional, untuk SEO
        'is_published',
    ];

    // Otomatis buat slug dari title jika slug kosong
    public static function boot()
    {
        parent::boot();
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }
}