<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
      use HasFactory;
      protected $fillable = [
          'body',
          'user_id',
          'post_id'
      ];

      public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
      {
          return $this->belongsTo(Post::class);
      }

      public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
      {
          return $this->belongsTo(User::class);
      }
}
