<?php

namespace App\Repositories;

use App\Models\Pusher;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PusherRepository
 * @package App\Repositories
 * @version September 11, 2018, 1:39 pm UTC
 *
 * @method Pusher findWithoutFail($id, $columns = ['*'])
 * @method Pusher find($id, $columns = ['*'])
 * @method Pusher first($columns = ['*'])
*/
class PusherRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pusher::class;
    }
}
