<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ScroreGirlZ  extends Model
{
    protected $table = 'scrore_girl_z';
    
    protected $fillable = [
        'days','SD4neg','SD3neg','SD2neg','SD1neg','SD0','SD1','SD2','SD3','SD4'
    ];
    public $timestamps = false;
}
