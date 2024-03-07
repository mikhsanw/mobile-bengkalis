{!! Form::open(array('id' => 'frmOji', 'route' => [$halaman->kode.'.update', $data->id], 'class' => 'form account-form', 'method' => 'PUT','files' => 'true')) !!}
<div class="row">
    <div class="col-md-12 col-md-12 form-group">
        {!! Form::label('Nama', 'Namanya siapa ?', array('class' => 'col-md-6 control-label')) !!}
        {!! Form::text('nama', $data->user->nama, array('id' => 'nama', 'class' => 'form-control', 'placeholder' =>
        'Nama')) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label('username', 'Username', array('class' => 'control-label')) !!}
        {!! Form::text('username', $data->user->username, array('id' => 'username', 'class' => 'form-control',
        'placeholder' => 'Username', 'readonly')) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label('Password', 'Password', array('class' => 'control-label')) !!}
        <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
        <small>Kosongkan jika tidak perlu</small>
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label('Email', 'E-Mail', array('class' => 'control-label')) !!}
        {!! Form::text('email', $data->user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' =>
        'Email')) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label('kim_id', 'KIM', array('class' => 'control-label')) !!}
        {!! Form::select('kim_id',$kim, $data->kim_id, array('id' => 'kim_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih','style' => 'width:100%')) !!}
    </div>
    <div class="col-md-12 form-group">
        {!! Form::label('level_kim', 'Level', array('class' => 'control-label')) !!}
        {!! Form::select('level_kim',config('master.level_kim'), $data->level_kim, array('id' => 'level_kim', 'class' => 'form-control', 'placeholder'=>'Pilih','style' => 'width:100%')) !!}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span class="pesan"></span>
        <div id="output"></div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                <div id="statustxt">0%</div>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('table-list', 'datatable', array('id' => 'table-list')) !!}
{!! Form::close() !!}
<script src="{{ URL::asset('resources/vendor/jquery/jquery.enc.js') }}"></script>
<script src="{{ URL::asset('resources/vendor/jquery/jquery.form.js') }}"></script>
<script src="{{ URL::asset(config('master.aplikasi.author').'/js/ajax_progress.js') }}"></script>
<script src="{{ asset('backend/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<script>
    $('.modal-title').html('<span class="fa fa-edit"></span> Ubah {{$halaman->nama}}');
    $('.select2').select2();
</script>
