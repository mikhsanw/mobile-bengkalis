{!! Form::open(array('id' => 'frmOji', 'route' => [$halaman->kode.'.store'], 'class' => 'form account-form', 'method' => 'post', 'files' => 'true')) !!}
<div class="row">
    <div class="col-md-12">

		<p>
			{!! Form::label('nama', 'Masukkan Nama', ['class'=>'control-label']) !!}
			{!! Form::text('nama', null, array('id' => 'nama', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('alamat', 'Masukkan Alamat', ['class'=>'control-label']) !!}
			{!! Form::text('alamat', null, array('id' => 'alamat', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('keterangan', 'Masukkan Keterangan', ['class'=>'control-label']) !!}
			{!! Form::textarea('keterangan', null, array('id' => 'keterangan', 'class' => 'form-control', 'autocomplete' => 'off')) !!}
		</p>
		<p>
			{!! Form::label('kecamatan_id', 'Pilih Kecamatan', ['class'=>'control-label']) !!}
			{!! Form::select('kecamatan_id',$kecamatan_id, null, array('id' => 'kecamatan_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih','style' => 'width:100%')) !!}
		</p>
		<p>
			{!! Form::label('kelurahan_id', 'Pilih Kelurahan', ['class'=>'control-label']) !!}
			{!! Form::select('kelurahan_id',[], null, array('id' => 'kelurahan_id', 'class' => 'form-control select2', 'placeholder'=>'Pilih','style' => 'width:100%')) !!}
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
	.select{
		width: 100%;
	}
    .select2-container {
        z-index: 9999 !important;
    }
</style>
<script src="{{ URL::asset('resources/vendor/jquery/jquery.enc.js') }}"></script>
<script src="{{ URL::asset('resources/vendor/jquery/jquery.form.js') }}"></script>
<script src="{{ URL::asset(config('master.aplikasi.author').'/js/ajax_progress.js') }}"></script>
<script src="{{ URL::asset(config('master.aplikasi.author').'/'.$halaman->kode.'/'.\Auth::id().'/ajax.js') }}"></script>
<script src="{{ asset('backend/fromplugin/summernote/summernote.js') }}" async=""></script>
<script src="{{ asset('backend/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>
<script type="text/javascript">
    $('.modal-title').html('<span class="fa fa-edit"></span> Tambah {{$halaman->nama}}');
    $('.js-summernote').summernote({
        // toolbar: [['para', ['ul', 'ol']]],
        height: 200,
        dialogsInBody: true
    });
    $('.select2').select2();

	$(document).ready(function(){
        $('#kecamatan_id').on('change', function(){
            var kecamatan_id = $(this).val(); // Get the selected kecamatan ID

            // Make an AJAX request to fetch kelurahan options based on the selected kecamatan
            $.ajax({
                url: '/kims/get_kelurahan/' + kecamatan_id, // Replace this URL with your actual endpoint to fetch kelurahan options
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    // Clear previous kelurahan options
                    $('#kelurahan_id').empty();

                    // Populate kelurahan dropdown with fetched options
                    $.each(response, function(index, kelurahan){
                        $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama + '</option>');
                    });
                },
                error: function(xhr, status, error){
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>