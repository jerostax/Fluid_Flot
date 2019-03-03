<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function pictureProduct(){
        return $this->hasMany(PictureProduct::class);
    }
}
