<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['email'];

    /**
     * @param array $data
     * @return static|null
     */
    public static function storeSubscriber(array $data): ?self
    {
        return self::create($data);
    }
}
