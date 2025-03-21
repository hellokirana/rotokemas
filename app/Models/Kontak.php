<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    //
    use HasUuids;
    protected $fillable = ['title'];   
}
