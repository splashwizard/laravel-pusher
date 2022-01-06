<table class="table table-responsive" id="devices-table">
    <thead>
        <tr>
            <th>Deviceid</th>
        <th>Title</th>
        <th>Content</th>
        <th>Message Url</th>
        <th>Content Available</th>
        <th>Priority</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($devices as $device)
        <tr>
            <td>{!! $device->deviceId !!}</td>
            <td>{!! $device->title !!}</td>
            <td>{!! $device->content !!}</td>
            <td>{!! $device->message_url !!}</td>
            <td>{!! $device->content_available !!}</td>
            <td>{!! $device->priority !!}</td>
            <td>
                {!! Form::open(['route' => ['devices.destroy', $device->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('devices.show', [$device->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('devices.edit', [$device->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>