{!! Form::open(array('id' => 'frmOji', 'route' => [$halaman->kode.'.update', $data->id], 'class' => 'form account-form', 'method' => 'PUT', 'files' => 'true')) !!}
<div class="row">
    <div class="col-md-12">
		<p>
			{!! Form::label('nama', 'Masukkan Nama', ['class'=>'control-label']) !!}
			{!! Form::text('nama', $data->nama, array('id' => 'nama', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('keterangan', 'Masukkan Keterangan', ['class'=>'control-label']) !!}
			{!! Form::text('keterangan', $data->keterangan, array('id' => 'keterangan', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('link', 'Masukkan Link', ['class'=>'control-label']) !!}
			{!! Form::text('link', $data->link, array('id' => 'link', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('opd_id', 'Pilih Opd', ['class'=>'control-label']) !!}
			{!! Form::select('opd_id',$opd_id, $data->opd_id, array('id' => 'opd_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih')) !!}
		</p>
        <p>
            {!! Form::label('foto', 'Upload Logo', array('class' => 'control-label')) !!} <br/>
            {!! Form::file('foto', null, array('id' => 'foto', 'class' => 'form-control')) !!}
        </p>
        <p>
            {!! Form::label('jenis', 'Pilih jenis', array('class' => 'control-label')) !!}
            {!! Form::select('jenis', config('master.jenis_aplikasi'), $data->jenis, array('id' => 'jenis', 'class' => 'select2 form-control jenis', 'placeholder'=>'Pilih','style' => 'width:100%')) !!}
        </p>
    </div>
    <div class="col-md-12">
        <img src="{{$data->file->url_stream.'?t='.time() ?? '#'}}" style="background: transparent url({{asset('backend/img/loading.gif')}}) no-repeat center; width: 100%"/>
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
    $('.modal-title').html('<span class="fa fa-edit"></span> Ubah {{$halaman->nama}}');
    $('.js-summernote').summernote({
        // toolbar: [['para', ['ul', 'ol']]],
        height: 200,
        dialogsInBody: true
    });
</script>
