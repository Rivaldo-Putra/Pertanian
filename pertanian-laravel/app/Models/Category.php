<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tb_categories';
    protected $primaryKey = 'id_categories';
    public $timestamps = false;   // ← BARIS INI YANG DITAMBAH

    protected $fillable = ['nama_categories', 'price', 'description', 'photo'];
}