$(document).ready(function(){
	const glob_xhr = new XMLHttpRequest()
	const glob_url = window.location.origin

	function Capitalize(kata){
		var myStr = kata
		var firstChar = kata.substring(0, 1)
		firstChar = firstChar.toUpperCase()

		var tail = myStr.substring(1)
		myStr = firstChar + tail
		return myStr
	}

	function validationData(aksi){
		if (aksi == "delete") {
			$('#alert-successDelete').html('<div class="alert alert-danger">Gagal Menghapus data !</div>')
			loadData()
			setTimeout(function(){
				$('#alert-success'+Capitalize(aksi)+'').hide(1000)
				$('#alert-success'+Capitalize(aksi)+' .alert-danger').remove()
				$('#alert-success'+Capitalize(aksi)+'').show(2000)
			}, 5000)
		}else{
			$('#alert-success'+Capitalize(aksi)+'').html('<div class="alert alert-danger">Masih ada data yang kosong !</div>')
			setTimeout(function(){
				$('#alert-success'+Capitalize(aksi)+'').hide(1000)
				$('#alert-success'+Capitalize(aksi)+' .alert-danger').remove()
				$('#alert-success'+Capitalize(aksi)+'').show(2000)
			}, 5000)		
		}
	}

	function loadData(){
		var xhr = glob_xhr
		var url = glob_url + '/product/get-data'

		xhr.onloadstart = function(){
			$('#tbody-data').html('<tr><td colspan="4" align="center">Loading...</td></tr>')
		}

		xhr.onerror = function(){
			$('#tbody-data').html('<tr><td colspan="4" align="center">Gagal Mengambil Data</td></tr>')			
		}

		xhr.onloadend = function(){
			var table = ''
			var data = this.responseText
			if (JSON.parse(data).length > 0) {
				var data = JSON.parse(data)
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
				});
			}else{
				table = '<tr><td colspan="4" align="center">Data Kosong !</td></tr>'				
			}			
			$('#tbody-data').html(table)
			$('#table-dataTable').DataTable({
				"paging": false
			});
		}

		xhr.open("POST", url, true)
		xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
		xhr.send()
	}

	function saveData(){
		if ($('input[name="nama_produk"]').val() != "" && $('input[name="harga_produk"]').val() != "") {
			var xhr = new XMLHttpRequest()
			var url = glob_url + '/product/save'

			const params = {			
				nama: $('input[name="nama_produk"]').val(),			
				harga: $('input[name="harga_produk"]').val()
			}

			xhr.onloadstart = function(){
				$('#alert-successSave').html('<div class="alert alert-info">Loading ...</div>')			
			}

			xhr.onerror = function(){
				console.log('error')
			}

			xhr.onloadend = function(){
				console.log(this.responseText)
				if (this.responseText != "") {				
					$('input[name="nama_produk"]').val('')				
					$('input[name="harga_produk"]').val('')				
					$('#alert-successSave').html('<div class="alert alert-success">Berhasil menambah data !</div>')
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
		}else{
			validationData('save')
		}
	}

	function updateData(){
		if ($('input[name="edit_nama_produk"]').val() != "" && $('input[name="edit_harga_produk"]').val() != ""){
			var xhr = new XMLHttpRequest()
			var url = glob_url + '/product/update'

			const params = {
				id: $('input[name="edit_id_produk"]').val(),			
				nama: $('input[name="edit_nama_produk"]').val(),			
				harga: $('input[name="edit_harga_produk"]').val()
			}

			xhr.onloadstart = function(){
				$('#alert-successUpdate').html('<div class="alert alert-info">Loading ...</div>')			
			}

			xhr.onerror = function(){
				console.log('error')
			}

			xhr.onloadend = function(){
				console.log(this.responseText)
				if (this.responseText != "") {				
					$('input[name="nama_produk"]').val('')				
					$('input[name="harga_produk"]').val('')				
					$('#alert-successUpdate').html('<div class="alert alert-success">Berhasil update data !</div>')
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
		}else{
			validationData('update')
		}
	}

	loadData()

	$('#btn-saveData').click(function(){
		saveData()
	})

	$('body').on('click', '#btnUbah', function(){
		var id = $(this).closest('tr').find('td:nth-child(1)').text()
		var nama = $(this).closest('tr').find('td:nth-child(2)').text()
		var harga = $(this).closest('tr').find('td:nth-child(3)').text()
		$('input[name="edit_id_produk"]').val(id)
		$('input[name="edit_nama_produk"]').val(nama)
		$('input[name="edit_harga_produk"]').val(harga)
	})

	$('#btn-updateData').click(function(){
		updateData()
	})

	function deleteData(product_id){
		var xhr = new XMLHttpRequest()
		var url = glob_url + '/product/delete'

		const params = {
			id: product_id
		}

		xhr.onloadstart = function(){
			$('#alert-successDelete').html('<div class="alert alert-info">Loading ...</div>')			
		}

		xhr.onerror = function(){
			console.log('error')
		}

		xhr.onloadend = function(){
			var cek = JSON.parse(this.responseText)
			console.log(cek)
			if (cek == "success") {				
				$('#alert-successDelete').html('<div class="alert alert-success">Berhasil Menghapus data !</div>')
				loadData()
				setTimeout(function(){
					$('.alert-success').hide(1000)
				}, 5000)
			}else{
				validationData('delete')
			}
		}

		xhr.open("POST", url, true)
		xhr.setRequestHeader('Content-type', 'application/json')
		xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));			
		xhr.send(JSON.stringify(params))
	}

	$('body').on('click', '#btnHapus', function(){
		deleteData($(this).data('product_id'))
		// deleteData('99')
	})
})