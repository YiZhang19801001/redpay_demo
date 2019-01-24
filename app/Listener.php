<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listener extends Model
{
    protected $table = 'listener';
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    protected $fillable = ['request_body'];
}
