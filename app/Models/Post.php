<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'slug', 'content', 'image', 'user_id', 'category_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $count = Post::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }


}
