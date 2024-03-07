$(document).ready(function() {
	$('#datatable').DataTable({
		responsive: true,
		serverside: true,
		lengthChange: false,
		language: {
            url: "{{ asset('resources/vendor/datatables/js/indonesian.json') }}"
        },
		processing: true,
		serverSide: true,
		ajax: "{{ url($url_admin.'/'.$kode.'/data') }}",
		columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
				{ data: 'nama' },
				{ data: 'lokasi' },
				{ data: 'tanggal' },
				{ data: 'jenis',
					render: function (data, type, row) {
						return data==1?`<span class="text-muted">{{config('master.level_kegiatan_kim.1')}}</span>`: `<span class="text-muted">{{config('master.level_kegiatan_kim.2')}}</span>`;
						} 
				},
				{ data: 'deskripsi' },
				{ data: 'kim.nama' },

				{ data: 'action', orderable: false, searchable: false}
		    ]
    });
});
