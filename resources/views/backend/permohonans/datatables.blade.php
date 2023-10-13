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
				{ data: 'no_identitas' },
				{ data: 'nama' },
				{ data: 'alamat' },
				{ data: 'email' },
				{ data: 'no_telp' },
				{ data: 'pekerjaan' },
				{ data: 'rincian_informasi' },
				{ data: 'tujuan_penggunaan' },
				{ data: 'opd.nama' },
				{ data: 'cara_memperoleh' },
				{ data: 'salinan_informasi' },
				{ data: 'cara_mendapatkan' },

				{ data: 'action', orderable: false, searchable: false}
		    ]
    });
});
