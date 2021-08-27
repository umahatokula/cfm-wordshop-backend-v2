<!-- Name Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
            {!! Form::label('name', 'Name:') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Price Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
            {!! Form::label('price', 'Price:') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
            {!! Form::text('price', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Description Field -->
<div class="col-12 mb-20">
    <div class="row mbn-10">
        <div class="col-sm-3 col-12 mb-10">
            {!! Form::label('description', 'Description:') !!}
        </div>
        <div class="col-sm-9 col-12 mb-10">
            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<!-- Password Field -->
<div class="col-12 mb-20">
    <div class="adomx-checkbox-radio-group inline">

        <label class="adomx-switch"> <span class="text">Activate/Deactivate </span> &nbsp
            <input name="is_active"  value="false" type="checkbox" class="toggle-switch"> <i class="lever"></i></label>

    </div>
</div>

<hr>

<!-- Submit Field -->
<div class="form-group col-sm-12 text-center">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('bundles.index') !!}" class="btn btn-secondary">Cancel</a>
</div>
