# NETCOID

### NETCOID.com
digunakan untuk server dev atau edge

### NETWORKS.co.id
sementara tetap diaktifkan

### PENTING
`/config` harus dipindahkan secara manual ke production jika terdapat perubahan

### INSTALL DI LOCALHOST

	// ubah /config/* Apps, Database, dsb sesuai dengan enviroment
	// jika difolder misal localhost/sebuahfolder maka tambahkan 'folder' => '/sebuahfolder/' di apps,
	// database jangan lupa

### HOW DEPLOY
	// pindahkan wiki/ftpdata ke .git/ftpdata
	// pindahkan wiki/config ke .git/config
	cd engine/scripts
	./deploy setup
	./deploy all
	// ubah config/Apps.php dimana development TRUE menjadi false
	// uji coba dilocalhost sebelum push
	./deploy.py deploy
