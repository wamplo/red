### DATABASE MIGRATION ###

#### Penamaan
penamaan database dan tabel harus bedasarkan applikasinya contoh

### TODO 

admin/user berarti admin_user

> dibaca tabel user yang berada di app admin

netcoid/user berarti netcoid_user

> dibaca tabel user yang berada di app netcoid

yang diubah:

- models
- migrations

on prosess nantinya kaya gini:

	rename table comments to netcoid_comments;
	rename table follow to netcoid_follow;
	rename table groups to netcoid_groups;
	rename table mentions to netcoid_mentions;
	rename table posts to netcoid_posts;
	rename table users to netcoid_users;
	rename table messages to netcoid_messages;

ditambah semua fk key, contoh: `fk_vipusers.uid_acc.users.uid`

> dibaca uid_acc dari vipusers ke merajuk ke uid dari users

menjadi `fk_admin_vipusers.uid_acc.netcoid_users.uid`

> dibaca uid_acc dari vip users di app admin merajuk ke uid dari users di app netcoid

#### Catatan

untuk database yang terdapat `/*NOT CORE*/` berarti belum disempurnakan atau disatukan dengan tabel lainnya misal:

- pemasangan forgainkey
- optimasi database

sehingga:

- misal user kita hapus uid 1, pada tabel yang belum core harus kita hapus secara manual