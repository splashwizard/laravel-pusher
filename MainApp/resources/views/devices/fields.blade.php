<!-- Deviceid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deviceId', 'Deviceid:') !!}
    {!! Form::text('deviceId', null, ['class' => 'form-control']) !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
</div>

<!-- Message Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('message_url', 'Message Url:') !!}
    {!! Form::text('message_url', null, ['class' => 'form-control']) !!}
</div>

<!-- Content Available Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('content_available', 'Content Available:') !!}
    {!! Form::textarea('content_available', null, ['class' => 'form-control']) !!}
</div>

<!-- Priority Field -->
<div class="form-group col-sm-6">
    {!! Form::label('priority', 'Priority:') !!}
    {!! Form::number('priority', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('devices.index') !!}" class="btn btn-default">Cancel</a>
</div>
