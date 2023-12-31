{!! Form::open(array('id' => 'frmOji', 'route' => [$halaman->kode.'.store'], 'class' => 'form account-form', 'method' => 'post', 'files' => 'true')) !!}
<div class="row">
    <div class="col-md-12">

		<p>
			{!! Form::label('no_identitas', 'Masukkan No_identitas', ['class'=>'control-label']) !!}
			{!! Form::text('no_identitas', null, array('id' => 'no_identitas', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('nama', 'Masukkan Nama', ['class'=>'control-label']) !!}
			{!! Form::text('nama', null, array('id' => 'nama', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('alamat', 'Masukkan Alamat', ['class'=>'control-label']) !!}
			{!! Form::text('alamat', null, array('id' => 'alamat', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('email', 'Masukkan Email', ['class'=>'control-label']) !!}
			{!! Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('no_telp', 'Masukkan No_telp', ['class'=>'control-label']) !!}
			{!! Form::text('no_telp', null, array('id' => 'no_telp', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('pekerjaan', 'Masukkan Pekerjaan', ['class'=>'control-label']) !!}
			{!! Form::text('pekerjaan', null, array('id' => 'pekerjaan', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('rincian_informasi', 'Masukkan Rincian_informasi', ['class'=>'control-label']) !!}
			{!! Form::text('rincian_informasi', null, array('id' => 'rincian_informasi', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('tujuan_penggunaan', 'Masukkan Tujuan_penggunaan', ['class'=>'control-label']) !!}
			{!! Form::text('tujuan_penggunaan', null, array('id' => 'tujuan_penggunaan', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('opd_id', 'Pilih Opd_id', ['class'=>'control-label']) !!}
			{!! Form::select('opd_id',$opd_id, null, array('id' => 'opd_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih')) !!}
		</p>
		<p>
			{!! Form::label('cara_memperoleh', 'Masukkan Cara_memperoleh', ['class'=>'control-label']) !!}
			{!! Form::text('cara_memperoleh', null, array('id' => 'cara_memperoleh', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('salinan_informasi', 'Masukkan Salinan_informasi', ['class'=>'control-label']) !!}
			{!! Form::text('salinan_informasi', null, array('id' => 'salinan_informasi', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('cara_mendapatkan', 'Masukkan Cara_mendapatkan', ['class'=>'control-label']) !!}
			{!! Form::text('cara_mendapatkan', null, array('id' => 'cara_mendapatkan', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
            {!! Form::label('foto', 'Upload Logo', array('class' => 'control-label')) !!} <br/>
            {!! Form::file('foto', null, array('id' => 'foto', 'class' => 'form-control')) !!}
        </p>
    </div>
	{!! Form::hidden('table-list', 'datatable', array('id' => 'table-list')) !!}
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
{!! Form::close() !!}
<style>
    .select2-container {
        z-index: 9999 !important;
    }
</style>
<script src="{{ URL::asset('resources/vendor/jquery/jquery.enc.js') }}"></script>
<script src="{{ URL::asset('resources/vendor/jquery/jquery.form.js') }}"></script>
<script src="{{ URL::asset(config('master.aplikasi.author').'/js/ajax_progress.js') }}"></script>
<script src="{{ URL::asset(config('master.aplikasi.author').'/'.$halaman->kode.'/'.\Auth::id().'/ajax.js') }}"></script>
<script src="{{ asset('backend/fromplugin/summernote/summernote.js') }}" async=""></script>
<script type="text/javascript">
    $('.modal-title').html('<span class="fa fa-edit"></span> Tambah {{$halaman->nama}}');
    $('.js-summernote').summernote({
        // toolbar: [['para', ['ul', 'ol']]],
        height: 200,
        dialogsInBody: true
    });
</script>