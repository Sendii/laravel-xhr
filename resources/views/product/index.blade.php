@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
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
<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm my-2" data-toggle="modal" data-target="#modaltambahData">Tambah Data</a>
<div id="alert-successDelete" class="my-2">
	
</div>
<table class="table table-hover table-bordered" id="table-dataTable">
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
<script src="{{asset('products/xhr-withajax.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
		
	} );
</script>
@endsection