{!! Form::open(array('id' => 'frmOji', 'route' => [$halaman->kode.'.store'], 'class' => 'form account-form', 'method' => 'post', 'files' => 'true')) !!}
<div class="row">
    <div class="col-md-12">

		<p>
			{!! Form::label('nama', 'Masukkan Nama', ['class'=>'control-label']) !!}
			{!! Form::text('nama', null, array('id' => 'nama', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('lokasi', 'Masukkan Lokasi', ['class'=>'control-label']) !!}
			{!! Form::text('lokasi', null, array('id' => 'lokasi', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('tanggal', 'Masukkan Tanggal', ['class'=>'control-label']) !!}
			{!! Form::string('tanggal', null, array('id' => 'tanggal', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('jenis', 'Masukkan Jenis', ['class'=>'control-label']) !!}
			{!! Form::string('jenis', null, array('id' => 'jenis', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('deskripsi', 'Masukkan Deskripsi', ['class'=>'control-label']) !!}
			{!! Form::string('deskripsi', null, array('id' => 'deskripsi', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('kim_id', 'Pilih Kim_id', ['class'=>'control-label']) !!}
			{!! Form::select('kim_id',$kim_id, null, array('id' => 'kim_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih')) !!}
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