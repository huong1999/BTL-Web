<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <label for="class_id">Room</label>
    <select name="room_id" id="room_id" class="form-control">
        @foreach($rooms as $key => $value)
            <option value="{{ $key }}" @isset($subject) {{ $subject->room_id == $key ? 'selected' : '' }} @endisset>{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
