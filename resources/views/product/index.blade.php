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
<div class="modal fade" id="modaleditData" tabindex="-1" role="dialog" aria-labelledby="modaleditDataLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="modal-product input">
			<div class="modal-header">
				<h5 class="modal-title" id="modaleditDataLabel">Ubah Produk</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="exampleInputEmail1">Nama Produk</label>
					<input type="hidden" class="form-control" name="edit_id_produk">
					<input type="text" class="form-control" name="edit_nama_produk" placeholder="Nama Produk">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Harga Produk</label>
					<input type="number" class="form-control" name="edit_harga_produk" placeholder="Harga Produk">
				</div>
				<div class="form-group" id="alert-successUpdate">
					<!-- ini alert -->

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-warning btn-sm" data-dismiss="modal">Close</button>
				<button id="btn-updateData" class="btn btn-outline-primary btn-sm">Simpan</button>
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
	var btnTest = false;
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
				var itungtr = 0
				data.forEach( function(v, k) {
					itungtr++
					table += '<tr>'
					table += '<td>'+v.id+'</td>'
					table += '<td>'+v.nama+'</td>'
					table += '<td>'+v.harga+'</td>'
					table += '<td>'
					table += '<a href="javascript:void(0)" id="btnUbah" data-trid='+itungtr+' data-product_id='+v.id+' class="btn btn-outline-warning btn-sm mr-2" data-toggle="modal" data-target="#modaleditData">Ubah</a>'
					table += '<a href="javascript:void(0)" id="btnHapus" data-product_id='+v.id+' class="btn btn-outline-danger btn-sm">Hapus</a>'
					table += '</td>'
					table += '</tr>'
					document.getElementById('tbody-data').innerHTML = table
				});
				document.getElementById("btnUbah").addEventListener("click", function(){
					// alert(this.getAttribute('data-trid'))
					document.getElementsByName('edit_nama_produk')[0].value = "ea"
					document.getElementsByName('edit_harga_produk')[0].value = "9999"
				})
				btnTest = true
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
					document.getElementsByName("nama_produk")[0].value = ""
					document.getElementsByName("harga_produk")[0].value = ""
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
			xhr.send(JSON.stringify(params))
		}
		document.getElementById("btn-saveData").addEventListener("click", function(){
			saveData()
		})		

		function updateData(){

		}

		loadData()
	</script>
	@endsection