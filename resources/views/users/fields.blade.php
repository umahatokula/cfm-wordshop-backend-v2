<!-- Name Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
            {!! Form::label('name', 'Name:') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
            {!! Form::text('name', null, ['class' => 'form-control form-control-sm']) !!}
        </div>
    </div>
</div>

<!-- Email Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
            {!! Form::label('email', 'Email:') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
    {!! Form::email('email', null, ['class' => 'form-control form-control-sm']) !!}
        </div>
    </div>
</div>

<!-- Username Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
    {!! Form::label('username', 'Username:') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
    {!! Form::text('username', null, ['class' => 'form-control form-control-sm']) !!}
        </div>
    </div>
</div>

<!-- Password Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
    {!! Form::label('password', 'Password:') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
    {!! Form::password('password', null, ['class' => 'form-control form-control-sm']) !!}
        </div>
    </div>
</div>

<!-- Roles Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
    {!! Form::label('roles_id', 'Role(s):') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
    {!! Form::select('role_ids[]', $roles, null, ['class' => 'form-control form-control-sm select2', 'multiple']) !!}
        </div>
    </div>
</div>

<hr>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-secondary">Cancel</a>
</div>
