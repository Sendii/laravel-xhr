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