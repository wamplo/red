# DEPLOYING
pastikan bahwa semuanya sudah siap untuk dideploy

### SETUP

    ./deploy.py setup

### IMPORTANT
periksa config/Engine.php ubah

	'development'	=> TRUE

menjadi

	'development'	=> FALSE

coba dijalankan dilocalhost
jika berhasil lakukan deploy

### DEPLOY 

    ./deploy.py all // renders everything to www-static
    ./deploy.py deploy // ftp deploy to server