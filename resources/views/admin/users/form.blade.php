<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', 'Name: ', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
    {!! Form::label('email', 'Email: ', ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('password') ? ' /home/sanghas-error' : ''}}">
    {!! Form::label('password', 'Password: ', ['class' => 'control-label']) !!}
    @php
        $passwordOptions = ['class' => 'form-control'];
        if ($formMode === 'create') {
            $passwordOptions = array_merge($passwordOptions, ['required' => 'required']);
        }
    @endphp
    {!! Form::password('password', $passwordOptions) !!}
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <label for="class_id">Class</label>
    <select name="class_id" id="class_id" class="form-control">
        @foreach($classes as $key => $value)
            <option value="{{ $key }}" @isset($user) {{ $user->class_id == $key ? 'selected' : '' }} @endisset>{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="date_of_birth">Date of Birth</label>
    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ isset($user) ? $user->date_of_birth : old('date_of_birth') }}">
</div>
<div class="form-group">
    <label for="code">Code</label>
    <input type="text" class="form-control" name="code" id="code" value="{{ isset($user) ? $user->code : old('code') }}">
</div>
<div class="form-group{{ $errors->has('roles') ? ' has-error' : ''}}">
    {!! Form::label('role', 'Role: ', ['class' => 'control-label']) !!}
    {!! Form::select('roles[]', $roles, isset($user_roles) ? $user_roles : [], ['class' => 'form-control', 'multiple' => true]) !!}
</div>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
