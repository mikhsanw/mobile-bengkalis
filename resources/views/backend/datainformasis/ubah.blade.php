{!! Form::open(array('id' => 'frmOji', 'route' => [$halaman->kode.'.update', $data->id], 'class' => 'form account-form', 'method' => 'PUT', 'files' => 'true')) !!}
<div class="row">
    <div class="col-md-12">
		<p>
			{!! Form::label('nama', 'Masukkan Nama', ['class'=>'control-label']) !!}
			{!! Form::text('nama', $data->nama, array('id' => 'nama', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('opd_id', 'Pilih Opd_id', ['class'=>'control-label']) !!}
			{!! Form::select('opd_id',$opd_id, $data->opd_id, array('id' => 'opd_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih')) !!}
		</p>
		<p>
			{!! Form::label('view', 'Masukkan View', ['class'=>'control-label']) !!}
			{!! Form::text('view', $data->view, array('id' => 'view', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
            {!! Form::label('data', 'Upload Data Informasi', array('class' => 'control-label')) !!} <br/>
            {!! Form::file('data', null, array('id' => 'data', 'class' => 'form-control')) !!}
        </p>

    </div>
	<div class="col-8">
    @if($data->file)
        @if($data->file->extension=='pdf')
        <object data="{{$data->file->url_stream.'?t='.time() ?? '#'}}" type="application/pdf" style="background: transparent url({{asset('backend/img/loading.gif')}}) no-repeat center; width: 100%;height: 700px">
            <p>
                File PDF tidak dapat ditampilkan, silahkan download file
                <a download="{{$data->file->nama}}" href="{{$data->file->url_stream ?? '#'}}"><span class="fa fa-download"> di sini</span></a>
            </p>
        </object>
        @else
        <p>
            File tidak dapat ditampilkan, silahkan download file
            <a download="{{$data->file->nama}}" href="{{$data->file->url_download.'?t='.time() ?? '#'}}"><span class="fa fa-download"> di sini</span></a>
        </p>
        @endif
    @endif
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
