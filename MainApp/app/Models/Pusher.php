<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pusher
 * @package App\Models
 * @version September 11, 2018, 1:39 pm UTC
 *
 */
class Pusher extends Model
{
    use SoftDeletes;

    public $table = 'pusher';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'device_id',
        'registration_id',
        'push_enable',
        'platform',
        'user_email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
