<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{


    public function keywords()
    {
        return $this->hasMany(Article_keyword::class);
    }


    public function article_group()
    {
        return $this->belongsTo(Article_group::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function contents()
    {
        return $this->hasMany(Article_content::class)->orderBy('order', 'asc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
