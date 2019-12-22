<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group">
    <label for="">Exam</label>
    <select name="exam_id" id="" class="form-control">
        @foreach($exams as $key => $value)
            <option value="{{ $key }}" @isset($shift) {{ $shift->exam_id == $key ? 'selected' : '' }} @endisset>{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Subject</label>
    <select name="subject_id" id="" class="form-control">
        @foreach($subjects as $key => $value)
            <option value="{{ $key }}" @isset($shift) {{ $shift->subject_id == $key ? 'selected' : '' }} @endisset>{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="form-group{{ $errors->has('date_exam') ? 'has-error' : ''}}">
    {!! Form::label('date_exam', 'Date Exam', ['class' => 'control-label']) !!}
    {!! Form::date('date_exam', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('date_exam', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('start') ? 'has-error' : ''}}">
    {!! Form::label('start', 'Start', ['class' => 'control-label']) !!}
    {!! Form::text('start', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('end') ? 'has-error' : ''}}">
    {!! Form::label('end', 'End', ['class' => 'control-label']) !!}
    {!! Form::text('end', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
