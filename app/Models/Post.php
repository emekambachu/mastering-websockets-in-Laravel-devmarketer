<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
      use HasFactory;
      protected $fillable = [
          'title',
          'content',
          'published'
      ];

      public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
      {
          return $this->belongsTo(User::class);
      }

      public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
      {
          return $this->hasMany(Comment::class);
      }
}
