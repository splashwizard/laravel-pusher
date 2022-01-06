<!-- Deviceid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deviceId', 'Deviceid:') !!}
    {!! Form::text('deviceId', null, ['class' => 'form-control']) !!}
</div>

<!-- Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('token', 'Token:') !!}
    {!! Form::text('token', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('pushers.index') !!}" class="btn btn-default">Cancel</a>
</div>
