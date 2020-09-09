@extends('layouts.app')

@section('content')
<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm my-2" data-toggle="modal" data-target="#modaltambahData">Tambah Data</a>
<div class="modal fade" id="modaltambahData" tabindex="-1" role="dialog" aria-labelledby="modaltambahDataLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="modal-product input">
			<div class="modal-header">
				<h5 class="modal-title" id="modaltambahDataLabel">Tambah Produk</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="exampleInputEmail1">Nama Produk</label>
					<input type="text" class="form-control" name="nama_produk" placeholder="Nama Produk">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Harga Produk</label>
					<input type="number" class="form-control" name="harga_produk" placeholder="Harga Produk">
				</div>
				<div class="form-group" id="alert-successSave">
					<!-- ini alert -->

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-warning btn-sm" data-dismiss="modal">Close</button>
				<button id="btn-saveData" class="btn btn-outline-primary btn-sm">Simpan</button>
			</div>
		</div>
	</div>
</div>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th scope="col">No.</th>
			<th scope="col">Nama</th>
			<th scope="col">Harga</th>
			<th scope="col">Aksi</th>
		</tr>
	</thead>
	<tbody id="tbody-data">

	</tbody>
</table>
@endsection

@section('scripts')
<script>
	function loadData(){
		var xhr = new XMLHttpRequest()
		var url = window.location.origin + '/product/get-data'

		xhr.onloadstart = function(){
			document.getElementById("tbody-data").innerHTML = '<tr><td colspan="4" align="center">Loading...</td></tr>'
		}

		xhr.onerror = function(){
			document.getElementById("tbody-data").innerHTML = '<tr><td colspan="4" align="center">Gagal Mengambil Data</td></tr>'
		}

		xhr.onloadend = function(){
			var table = ''
			if (this.responseText !== "") {
				var data = JSON.parse(this.responseText)
				data.forEach( function(v, k) {
					table += '<tr>'
					table += '<td>'+v.id+'</td>'
					table += '<td>'+v.nama+'</td>'
					table += '<td>'+v.harga+'</td>'
					table += '<td>'
					table += '<a href="javascript:void(0)" id="btnUbah" data-product_id='+v.id+' class="btn btn-outline-warning btn-sm mr-2" data-toggle="modal" data-target="#modaleditData">Ubah</a>'
					table += '<a href="javascript:void(0)" id="btnHapus" data-product_id='+v.id+' class="btn btn-outline-danger btn-sm">Hapus</a>'
					table += '</td>'
					table += '</tr>'
					document.getElementById('tbody-data').innerHTML = table
				});
			}
		}

		xhr.open("POST", url, true)
		xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
		xhr.send()
	}

	function saveData(){
		var xhr = new XMLHttpRequest()
		var url = window.location.origin + '/product/save'

		const params = {
			nama: document.getElementsByName('nama_produk')[0].value,
			harga: document.getElementsByName('harga_produk')[0].value
		}

		xhr.onloadstart = function(){
			document.getElementById("alert-successSave").innerHTML = '<div class="alert alert-info">Loading ...</div>'
		}

		xhr.onerror = function(){
				// document.getElementById("alert-successSave").innerHTML = '<div class="alert alert-danger">Gagal Menyimpan Data</div>'
				console.log('error')
			}

			xhr.onloadend = function(){
				console.log(this.responseText)
				if (this.responseText != "") {
					document.getElementById("alert-successSave").innerHTML = '<div class="alert alert-success">Berhasil menambah data !</div>'
					loadData()
					setTimeout(function(){
						$('.alert-success').hide(1000)
					}, 5000)
				}
			}

			xhr.open("POST", url, true)
			xhr.setRequestHeader('Content-type', 'application/json')
			xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
			// xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
			// xhr.setRequestHeader("Content-Type", "multipart/form-data");
			xhr.send(JSON.stringify(params))
		}
		document.getElementById("btn-saveData").addEventListener("click", function(){
			saveData()
			// alert(document.getElementsByName('nama_produk')[0].value)
		})

		loadData()
	</script>
	@endsection