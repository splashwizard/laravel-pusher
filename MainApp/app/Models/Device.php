<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Device
 * @package App\Models
 * @version September 10, 2018, 11:38 am UTC
 *
 * @property string title
 * @property time start_time
 * @property string body
 * @property integer event_type_id
 */
class Device extends Model
{
    use SoftDeletes;

    public $table = 'device';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'deviceId',
        'title',
        'content',
        'message_url',
        'content_available',
        'priority'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'body' => 'string',
        'event_type_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'start_time' => 'required',
        'event_type_id' => 'required'
    ];

    
}
