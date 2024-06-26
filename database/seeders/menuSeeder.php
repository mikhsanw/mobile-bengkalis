<?php
namespace Database\Seeders;
use App\Model\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class menuSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('menus')->truncate();
        $isi='[
          {
            "id": 40,
            "parent_id": null,
            "kode": "datakim",
            "nama": "Data KIM",
            "link": "datakim",
            "icon": "fas fa-people-carry",
            "tampil": 1,
            "urut": 1,
            "status": 1,
            "detail": {
              "model": "",
              "title": "",
              "keterangan": ""
            }
          },
          {
            "id": 29,
            "parent_id": null,
            "kode": "kontak",
            "nama": "Kontak",
            "link": "kontak",
            "icon": "far fa-address-book",
            "tampil": 1,
            "urut": 2,
            "status": 1,
            "detail": {
              "model": "Kontak",
              "title": "",
              "keterangan": ""
            }
          },
          {
            "id": 35,
            "parent_id": null,
            "kode": "beritas",
            "nama": "Berita",
            "link": "beritas",
            "icon": "far fa-newspaper",
            "tampil": 1,
            "urut": 3,
            "status": 1,
            "detail": {
              "model": "Berita",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 24,
            "parent_id": null,
            "kode": "slider",
            "nama": "Slider",
            "link": "slider",
            "icon": "fas fa-sliders-h",
            "tampil": 1,
            "urut": 4,
            "status": 1,
            "detail": {
              "model": "foto",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 37,
            "parent_id": null,
            "kode": "opds",
            "nama": "Opd",
            "link": "opds",
            "icon": "far fa-building",
            "tampil": 1,
            "urut": 5,
            "status": 1,
            "detail": {
              "model": "Opd",
              "title": "",
              "keterangan": null
            }
          },
          {
            "id": 38,
            "parent_id": null,
            "kode": "aplikasipemdas",
            "nama": "Aplikasi Pemda",
            "link": "aplikasipemdas",
            "icon": "fab fa-medapps",
            "tampil": 1,
            "urut": 6,
            "status": 1,
            "detail": {
              "model": "AplikasiPemda",
              "title": "",
              "keterangan": null
            }
          },
          {
            "id": 39,
            "parent_id": null,
            "kode": "permohonans",
            "nama": "Permohonan",
            "link": "permohonans",
            "icon": "empty",
            "tampil": 1,
            "urut": 7,
            "status": 0,
            "detail": {
              "model": "Permohonan",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 36,
            "parent_id": null,
            "kode": "datainformasis",
            "nama": "Data Informasi",
            "link": "datainformasis",
            "icon": "fas fa-file-alt",
            "tampil": 1,
            "urut": 8,
            "status": 1,
            "detail": {
              "model": "DataInformasi",
              "title": "",
              "keterangan": null
            }
          },
          {
            "id": 10,
            "parent_id": null,
            "kode": "pengaturan",
            "nama": "Pengaturan",
            "link": "pengaturan",
            "icon": "fas fa-cogs",
            "tampil": 1,
            "urut": 9,
            "status": 1,
            "detail": {
              "model": "",
              "title": "",
              "keterangan": ""
            }
          },
          {
            "id": 1,
            "parent_id": null,
            "kode": "pengaturanroot",
            "nama": "Pengaturan Root",
            "link": "pengaturanroot",
            "icon": "fab fa-android",
            "tampil": 1,
            "urut": 10,
            "status": 1,
            "detail": {
              "model": "",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 2,
            "parent_id": 1,
            "kode": "extra",
            "nama": "Extra",
            "link": "extra",
            "icon": "fas fa-expand-arrows-alt",
            "tampil": 1,
            "urut": 1,
            "status": 0,
            "detail": {
              "model": "",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 3,
            "parent_id": 1,
            "kode": "menu",
            "nama": "Menu",
            "link": "menu",
            "icon": "fas fa-th-list",
            "tampil": 1,
            "urut": 2,
            "status": 1,
            "detail": {
              "model": "Menu",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 4,
            "parent_id": 1,
            "kode": "aksesgrup",
            "nama": "Akses Grup",
            "link": "aksesgrup",
            "icon": "fas fa-universal-access",
            "tampil": 1,
            "urut": 3,
            "status": 1,
            "detail": {
              "model": "",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 6,
            "parent_id": 2,
            "kode": "aksesmenu",
            "nama": "Akses Menu",
            "link": "aksesmenu",
            "icon": "fab fa-accessible-icon",
            "tampil": 1,
            "urut": 1,
            "status": 1,
            "detail": {
              "model": "",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 34,
            "parent_id": 10,
            "kode": "aplikasi",
            "nama": "Aplikasi",
            "link": "aplikasi",
            "icon": "fas fa-laptop",
            "tampil": 1,
            "urut": 1,
            "status": 1,
            "detail": {
              "model": "aplikasi",
              "title": "",
              "keterangan": null
            }
          },
          {
            "id": 5,
            "parent_id": 10,
            "kode": "user",
            "nama": "User",
            "link": "user",
            "icon": "fas fa-users",
            "tampil": 1,
            "urut": 2,
            "status": 1,
            "detail": {
              "model": "",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 41,
            "parent_id": 40,
            "kode": "kims",
            "nama": "KIM",
            "link": "kims",
            "icon": "empty",
            "tampil": 1,
            "urut": 1,
            "status": 1,
            "detail": {
              "model": "Kim",
              "title": "",
              "keterangan": ""
            }
          },
          {
            "id": 42,
            "parent_id": 40,
            "kode": "kimanggota",
            "nama": "Anggota",
            "link": "kimanggota",
            "icon": "empty",
            "tampil": 1,
            "urut": 2,
            "status": 1,
            "detail": {
              "model": "KimAnggota",
              "title": null,
              "keterangan": null
            }
          },
          {
            "id": 43,
            "parent_id": 40,
            "kode": "kegiatankims",
            "nama": "Kegiatan KIM",
            "link": "kegiatankims",
            "icon": "empty",
            "tampil": 1,
            "urut": 3,
            "status": 1,
            "detail": {
              "model": "KegiatanKim",
              "title": "",
              "keterangan": ""
            }
          }
        ]';
        foreach (json_decode($isi, TRUE) as $menu) {
            Menu::create($menu);
        }
        Schema::enableForeignKeyConstraints();
    }
}
