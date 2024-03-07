{!! Form::open(array('id' => 'frmOji', 'route' => [$halaman->kode.'.store'], 'class' => 'form account-form', 'method' => 'post')) !!}
<div class="row">
    <div class="col-md-12 form-group">
        <div class="form-group">
            {!! Form::label('Nama', 'Siapa Namanya ?', array('class' => 'control-label')) !!}
            {!! Form::text('nama', NULL, array('id' => 'nama', 'class' => 'form-control', 'placeholder' => 'Nama')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('username', 'Username', array('class' => 'control-label')) !!}
            {!! Form::text('username', NULL, array('id' => 'username', 'class' => 'form-control', 'placeholder' => 'Username')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Password', 'Password', array('class' => 'control-label')) !!}
            <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
        </div>
        <div class="form-group">
            {!! Form::label('email', 'E-Mail', array('class' => 'control-label')) !!}
            {!! Form::text('email', NULL, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('kim_id', 'KIM', array('class' => 'control-label')) !!}
            {!! Form::select('kim_id',$kim_id, null, array('id' => 'kim_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih','style' => 'width:100%')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('level_kim', 'Level', array('class' => 'control-label')) !!}
            {!! Form::select('level_kim',config('master.level_kim'), null, array('id' => 'level_kim', 'class' => 'form-control', 'placeholder'=>'Pilih','style' => 'width:100%')) !!}
        </div>
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
<style>
    .select2-container {
        z-index: 9999 !important;
    }
</style>
<script src="{{ URL::asset('resources/vendor/jquery/jquery.enc.js') }}"></script>
<script src="{{ URL::asset('resources/vendor/jquery/jquery.form.js') }}"></script>
<script src="{{ URL::asset(config('master.aplikasi.author').'/js/ajax_progress.js') }}"></script>
<script src="{{ asset('backend/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<script>
    $('.modal-title').html('<i class="{!! $halaman->icon !!}"></i> Tambah {{ $halaman->nama }}');
    $('.select2').select2();
</script>
