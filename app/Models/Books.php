<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Image;

class Books extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'isbn',
        'description'
    ];

    /**
     * @param $url
     * @return string
     */
    public static function bookImage($url)
    {
        $unique_id = uniqid();
        $year = date("Y");
        $month = date("m");
        $date = date("d-m-Y");


        if (!file_exists('storage/' . $year . '/' . $month . '/' . $date)) {
            mkdir('storage/' . $year . '/' . $month . '/' . $date, 0777, true);
        }

        $path = 'storage/' . $year . '/' . $month . '/' . $date . '/' . $unique_id . ".jpg";

        \Image::make($url)->resize(200, 400)->save($path);

        $img = $unique_id . ".jpg";
        return $img;
    }
}
