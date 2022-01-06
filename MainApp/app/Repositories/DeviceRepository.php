<?php

namespace App\Repositories;

use App\Models\Device;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DeviceRepository
 * @package App\Repositories
 * @version September 10, 2018, 11:38 am UTC
 *
 * @method Device findWithoutFail($id, $columns = ['*'])
 * @method Device find($id, $columns = ['*'])
 * @method Device first($columns = ['*'])
*/
class DeviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'deviceId',
        'title',
        'content',
        'message_url',
        'content_available',
        'priority'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Device::class;
    }
}
