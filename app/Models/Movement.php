<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['type', 'category_id', 'quantity', 'value', 'date', 'description', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function totalEntries()
    {
        return self::where('type', 'entry')->sum('value');
    }

    public static function totalExits()
    {
        return self::where('type', 'exit')->sum('value');
    }

    public static function net()
    {
        return self::totalEntries() - self::totalExits();
    }
}