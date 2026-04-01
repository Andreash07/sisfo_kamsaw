<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sisfo - GKP Kampung Sawah</title>
  <style>
    table{
      border: 1px #000 solid;
      border-spacing: 0;
    }
    td{
      border: 1px #000 solid;
      border-spacing: 0;
    }
    th{
      border: 1px #000 solid;
      border-spacing: 0;
    }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>Kode_Data</th>
        <th>Nama_Gereja</th>
        <th>Nama_Wilayah</th>
        <th>No_Anggota</th>
        <th>No_Keluarga</th>
        <th>Hubungan_Keluarga</th>
        <th>Nama_Jemaat</th>
        <th>Masuk_Tanggal</th>
        <th>Masuk_Asal</th>
        <th>Masuk_Surat</th>
        <th>Keluar_Tanggal</th>
        <th>Keluar_Tujuan</th>
        <th>Keluar_Surat</th>
        <th>Baptis_SIDI</th>
        <th>Baptis_Gereja</th>
        <th>Baptis_Tanggal</th>
        <th>Baptis_Pendeta</th>
        <th>SIDI_Gereja</th>
        <th>SIDI_Tanggal</th>
        <th>SIDI_Pendeta</th>
        <th>Jenis_Kelamin</th>
        <th>Darah</th>
        <th>Rhesus</th>
        <th>Kota_Lahir</th>
        <th>Tanggal_Lahir</th>
        <th>Kota_Mati</th>
        <th>Tanggal_Mati</th>
        <th>Sebab_Mati</th>
        <th>Alamat</th>
        <th>Kode_Pos</th>
        <th>RT</th>
        <th>RW</th>
        <th>Propinsi</th>
        <th>Kota_Kabupaten</th>
        <th>Kecamatan</th>
        <th>Kelurahan_Desa</th>
        <th>Status_Nikah</th>
        <th>Nikah_Gereja</th>
        <th>Nikah_Tanggal</th>
        <th>Nikah_Pendeta</th>
        <th>Pendidikan</th>
        <th>Jurusan_Prodi</th>
        <th>Pekerjaan</th>
        <th>Bidang_Pekerjaan</th>
        <th>Disabilitas</th>
        <th>Catatan_Khusus</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        foreach ($data_internal as $key => $value) {
          // code...
          $datasinode=array();
          $datasinode['Kode_Data']="";
          $datasinode['Nama_Gereja']="";
          $datasinode['Nama_Wilayah']="";
          $datasinode['No_Anggota']="";
          $datasinode['No_Keluarga']="";
          $datasinode['Hubungan_Keluarga']="";
          $datasinode['Nama_Jemaat']="";
          $datasinode['Masuk_Tanggal']="";
          $datasinode['Masuk_Asal']="";
          $datasinode['Masuk_Surat']="";
          $datasinode['Keluar_Tanggal']="";
          $datasinode['Keluar_Tujuan']="";
          $datasinode['Keluar_Surat']="";
          $datasinode['Baptis_SIDI']="";
          $datasinode['Baptis_Gereja']="";
          $datasinode['Baptis_Tanggal']="";
          $datasinode['Baptis_Pendeta']="";
          $datasinode['SIDI_Gereja']="";
          $datasinode['SIDI_Tanggal']="";
          $datasinode['SIDI_Pendeta']="";
          $datasinode['Jenis_Kelamin']="";
          $datasinode['Darah']="";
          $datasinode['Rhesus']="";
          $datasinode['Kota_Lahir']="";
          $datasinode['Tanggal_Lahir']="";
          $datasinode['Kota_Mati']="";
          $datasinode['Tanggal_Mati']="";
          $datasinode['Sebab_Mati']="";
          $datasinode['Alamat']="";
          $datasinode['Kode_Pos']="";
          $datasinode['RT']="";
          $datasinode['RW']="";
          $datasinode['Propinsi']="";
          $datasinode['Kota_Kabupaten']="";
          $datasinode['Kecamatan']="";
          $datasinode['Kelurahan_Desa']="";
          $datasinode['Status_Nikah']="";
          $datasinode['Nikah_Gereja']="";
          $datasinode['Nikah_Tanggal']="";
          $datasinode['Nikah_Pendeta']="";
          $datasinode['Pendidikan']="";
          $datasinode['Jurusan_Prodi']="";
          $datasinode['Pekerjaan']="";
          $datasinode['Bidang_Pekerjaan']="";
          $datasinode['Disabilitas']="";
          $datasinode['Catatan_Khusus']="";
          if(isset($data_sinode[$value->no_anggota])){
            $datasinode=(array)$data_sinode[$value->no_anggota];
          }

          $baptis_sidi='Tidak Diketahui'; #ini defaultnya
          if($value->status_baptis==1){
            $baptis_sidi='Baptis';
          }
          if($value->status_sidi==1){
            $baptis_sidi='SIDI';
          }

          $jns_kelamin='Tidak Diketahui';
          if($value->jns_kelamin=='L'){
            $jns_kelamin='Pria';
          }
          if($value->jns_kelamin=='P'){
            $jns_kelamin='Wanita';
          }

          if($value->tmpt_meninggal == '' || $value->tmpt_meninggal == null){
            $value->tgl_attestasi_keluar=$value->tgl_meninggal;
          }
          #echo "<pre>"; print_r($datasinode); echo "</pre>"; die(); 
      ?>
          <tr>
            <td><?=$datasinode['Kode_Data'];?></td>
            <td>GKP Kampung Sawah</td>
            <td>Teritorial <?=$value->kwg_wil;?></td>
            <td>'<?=$value->no_anggota;?></td>
            <td>'<?=$value->no_keluarga;?></td>
            <td><?=$value->hub_keluarga;?></td>
            <td><?=$value->nama_lengkap;?></td>
            <td><?=check_tgl_00($value->tgl_attestasi_masuk);?></td>
            <td><?=$value->pindah_dari;?></td>
            <td><!--No Surat Masuk--></td>
            <td><?=check_tgl_00($value->tgl_attestasi_keluar);?></td>
            <td><!--No Keluar Tujuan--></td>
            <td><!--No Surat Keluar--></td>
            <td><?=$baptis_sidi;?></td>
            <td><?=$value->tmpt_baptis;?></td>
            <td><?=$value->tgl_baptis;?></td>
            <td><!--Baptis Pendeta--></td>
            <td><?=$value->tmpt_sidi;?></td>
            <td><?=$value->tgl_sidi;?></td>
            <td><!--SIDI Pendeta--></td>
            <td><?=$jns_kelamin;?></td>
            <td><?=$value->golongandarah;?></td>
            <td><!--Rhesus Darah-->Tidak Diketahui</td>
            <td><?=$value->tmpt_lahir;?></td>
            <td><?=check_tgl_00($value->tgl_lahir);?></td>
            <td><?=$datasinode['Kota_Mati'];?></td>
            <td><?=check_tgl_00($value->tgl_meninggal); //$datasinode['Tanggal_Mati'];?></td>
            <td><?=$datasinode['Sebab_Mati'];?></td>
            <td><?=$datasinode['Alamat'];?></td>
            <td><?=$datasinode['Kode_Pos'];?></td>
            <td><?=$datasinode['RT'];?></td>
            <td><?=$datasinode['RW'];?></td>
            <td><?=$datasinode['Propinsi'];?></td>
            <td><?=$datasinode['Kota_Kabupaten'];?></td>
            <td><?=$datasinode['Kecamatan'];?></td>
            <td><?=$datasinode['Kelurahan_Desa'];?></td>
            <td><?=$value->status_kawin;?></td>
            <td><?=$value->tmpt_nikah;?></td>
            <td><?=check_tgl_00($value->tgl_nikah);?></td>
            <td><?=$datasinode['Nikah_Pendeta'];?></td>
            <td><?=$value->pndk_akhir;?></td>
            <td><?=$datasinode['Jurusan_Prodi'];?></td>
            <td><?=$value->pekerjaan;?></td>
            <td><?=$datasinode['Bidang_Pekerjaan'];?></td>
            <td><?=$datasinode['Disabilitas'];?></td>
            <td><?=$datasinode['Catatan_Khusus'];?></td>
          </tr>
      <?php 
        }
      ?>
    </tbody>
    
  </table>
</body>
</html>