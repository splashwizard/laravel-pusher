<table class="table table-responsive" id="pushers-table">
    <thead>
        <tr>
            <th>Deviceid</th>
        <th>Token</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pushers as $pusher)
        <tr>
            <td>{!! $pusher->deviceId !!}</td>
            <td>{!! $pusher->token !!}</td>
            <td>
                {!! Form::open(['route' => ['pushers.destroy', $pusher->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('pushers.show', [$pusher->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('pushers.edit', [$pusher->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>