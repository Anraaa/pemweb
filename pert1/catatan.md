# Topik Tentang Website

Website mempunyai address, misal facebook.com. Seperti identitas atau biasa disebut domain. Setiap website yang dipublish menggunakan domain.

# HTML

bahasa general yang digunakan untuk developing website.

## Div Pada HTML

div itu dipake buat mengelompokkan tag html lain. contoh
```html
<div>
    This is a div element.
    <p>This is a paragraph inside the div.</p>
</div>
```

## Tag A `<a></a>`

Tag tersebut digunakan untuk membuat link pada suatu website. contoh `<a href="url">link text</a>`

---

# Kegunaan Docker

docker digunakan untuk menjalankan app, database, dan nginx. lebih mudah dikonfigurasi antara windows ke vps dibanding xampp. 

## A. Membahas docker-compose.yml
- version adalah versi yang digunakan. 
- service adalah layanan yang digunakan. 
  - web digunakan didalam service menggunakan nginx versi latest (terbaru). 
  - port yang digunakan adalah 80:80.
  - volumes adalah tempat dimana file akan disimpan.

## B. nginx.conf
- nginx adalah webserver, pengganti xampp. Yang dimana scopenya lebih besar seperti load balance, dll
- port bisa diganti sesuai dengan listen di docker-compose.yml.

# Analisa 

Minimal analisa harus ada 5W + 1H dan swot. Misal
-  Apa itu DOcker? (what)
-  Kapan Docker digunakan? (where)
-  Dimana Docker digunakan? (when)
-  Siapa yang menggunakan docker? (who)
-  Kenapa Docker digunakan? (why)
-  dll
Dalam 5W + 1H tidak selalu digunakan. Hanya berdasarkan kebutuhan, misal hanya what, when, dan where aja.

# Hal Wajib

Disetiap pertemuan harus ada analisa, ngodingnya sama catatan. Itu harus disetor ke pa jep, kalo ga setor gabole cabut.

# Project

Membuat website company profile yang dikerjakan sebelum UTS. Project akhir adalah kasus yang dimana setiap orang mendapat kasus yang berbeda beda. Kriteria penilaian utama adalah kesesuaiian antara analisa dengan websitenya. Setelah itu maka akan dilakukan penilaian dari clean codenya.

# Source

Mengambil source code, template, plugin atau apapun yang mengambil sesuatu dari orang lain usahakan dikasih sumbernya dari mana.
