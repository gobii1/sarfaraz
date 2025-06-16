<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'jasa_id', // Untuk menyimpan ID jasa yang dipilih
        'message',
        'is_read',
    ];

    /**
     * Get the jasa that the inquiry is about.
     */
    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}