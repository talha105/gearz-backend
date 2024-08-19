<?php

namespace App;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;

class Intervention_Image
{
        public static function imageResize($image){
                $file = Image::make($image);
                $file->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    return $file;
        }
}
