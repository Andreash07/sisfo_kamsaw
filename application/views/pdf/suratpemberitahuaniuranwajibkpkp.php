<?php 
$bulanID = [
		    1 => 'Januari',
		    2 => 'Februari',
		    3 => 'Maret',
		    4 => 'April',
		    5 => 'Mei',
		    6 => 'Juni',
		    7 => 'Juli',
		    8 => 'Agustus',
		    9 => 'September',
		    10 => 'Oktober',
		    11 => 'November',
		    12 => 'Desember'
		];
$angkaID = [
            1 => 'Satu',
            2 => 'Dua',
            3 => 'Tiga',
            4 => 'Empat',
            5 => 'Lima',
            6 => 'Enam',
            7 => 'Tujuh',
            8 => 'Delapan',
            9 => 'Sembilan',
            0 => '-'
        ];
#$recid=$_GET['auth'];
$s="";
?>
<style>
        /* =========================
           PAGE / PRINT
        ========================== */
        @page {
            size: A4;
            margin: 15mm 17mm 15mm 17mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
        }

        .page {
            width: 90%;
            min-height: 267mm;
            position: relative;
        }

        .kop-nama-gereja {
    font-family: helvetica;
    font-size: 19pt;
    font-weight: bold;
    text-align: center;
    /*line-height: 1.05;*/
    margin-top: 0;
}
/* =====================================================
   KOP SURAT
   ===================================================== */

.kop-surat {
    width: 180mm;

    border-collapse: collapse;
    border-spacing: 0;

    margin: 0;
    padding: 0;

    table-layout: fixed;

    font-family: helvetica;

    color: #000;
}


/* =====================================================
   KOLOM LOGO
   ===================================================== */

.kop-logo {
    width: 37mm;

    padding: 0;
    margin: 0;

    text-align: center;

    vertical-align: top;
}


/* =====================================================
   LOGO GKP
   ===================================================== */

.logo-gkp {
    width: 35mm;
    height: 35mm;

    display: block;

    margin: 0 auto;
}


/* =====================================================
   KOLOM INFORMASI
   ===================================================== */

.kop-info {
    width: 137mm;

    padding: 0 0 0 2mm;
    margin: 0;

    text-align: left;

    vertical-align: top;
}


/* =====================================================
   NAMA GEREJA
   ===================================================== */

.kop-nama-gereja {
    font-family: helvetica;

    font-size: 19pt;

    font-weight: bold;

    text-align: center;

    /*line-height: 1.05;*/

    margin-top: 0;
}


/* =====================================================
   PGI
   ===================================================== */

.kop-pgi {
    font-family: helvetica;

    font-size: 9pt;

    font-weight: bold;

    text-align: center;

    /*line-height: 1.2;*/

    /*margin-top: 1mm;*/
}


/* =====================================================
   NAMA JEMAAT
   ===================================================== */

.kop-nama-jemaat {
    font-family: helvetica;

    font-size: 14pt;

    font-weight: bold;

    text-align: center;

    /*line-height: 1.1;*/

    /*margin-top: 1mm;*/

    margin-bottom: 1mm;
}


/* =====================================================
   DETAIL ALAMAT
   ===================================================== */

.kop-detail {
    width: 100%;

    border-collapse: collapse;
    border-spacing: 0;

    table-layout: fixed;

    font-family: helvetica;

    font-size: 7.2pt;

    /*line-height: 1.05;*/
}


.kop-detail td {
    border: none;

    padding: 0.5mm 0;

    vertical-align: top;
}


/* label */

.detail-label {
    width: 38mm;

    font-weight: bold;
}


/* titik dua */

.detail-colon {
    width: 4mm;

    text-align: center;
}


/* isi */

.kop-detail td:last-child {
    width: auto;

    padding-left: 1mm;
}


/* =====================================================
   GARIS BAWAH KOP
   ===================================================== */

.kop-garis {
    padding: 1.5mm 0 0 0;

    border: none;
}


.garis-atas {
    width: 200mm;

    height: 1.2mm;

    background: #000;

    margin: 0;
}


.garis-bawah {
    width: 200mm;

    height: 0.35mm;

    background: #000;

    margin-top: -2mm;
}

        /* =========================
           TANGGAL
        ========================== */

        .tanggal {
            text-align: right;
            margin-bottom: 8px;
        }

        /* =========================
           ALAMAT / TUJUAN
        ========================== */

        .tujuan {
            margin-left: 0;
            line-height: 1.25;
            margin-bottom: 8px;
        }

        .tujuan .nama {
            font-weight: bold;
            margin-top: 5px;
        }

        .hal {
            margin-top: 6px;
        }

        /* =========================
           ISI SURAT
        ========================== */

        .salutation {
            margin-top: 34px;
            font-weight: bold;
            font-style: italic;
        }

        .paragraph {
            text-align: justify;
            line-height: 1.25;
            margin: 0 0 10px 0;
        }

        .paragraph-indent {
            text-indent: 0;
        }

        .bold-italic {
            font-weight: bold;
            font-style: italic;
        }

        /* =========================
           TABLE
        ========================== */

        .table-wrapper {
            margin-bottom: 15px;
            width: 190mm;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 9pt;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 3px 0px 3px 0px;
            vertical-align: middle;
        }

        .data-table th {
            text-align: center;
            font-weight: bold;
            line-height: 1.05;
        }

        .data-table td {
            line-height: 1.1;
        }

        .data-table .center {
            text-align: center;
        }

        .data-table .right {
            text-align: right;
        }

        .col-no {
            width: 5%;
        }

        .col-nama {
            width: 27%;
        }

        .col-wil {
            width: 5.5%;
        }

        .col-iuran {
            width: 11%;
        }

        .col-bulan {
            width: 15%;
        }

        .col-sisa {
            width: 17%;
        }

        .col-buku {
            width: 19.5%;
        }

        /* =========================
           PAYMENT INFO
        ========================== */

        .payment-info {
            font-weight: bold;
            font-style: italic;
        }

        /* =========================
           PENUTUP
        ========================== */

        .closing {
            text-align: justify;
            line-height: 1.25;
            margin-top: 17px;
        }
/* =====================================================
   JUDUL TANDA TANGAN
   ===================================================== */

.signature-title {
    width: 190mm;

    text-align: center;

    line-height: 1.2;

    margin-top: 9mm;
    margin-bottom: 5mm;
}


/* =====================================================
   TABEL TANDA TANGAN
   ===================================================== */

.signature-table {
    width: 190mm;

    border-collapse: collapse;
    border-spacing: 0;

    table-layout: fixed;

    margin: 0;
    padding: 0; 
    border: 1px solid #000;
}


/* Semua border dihilangkan */

.signature-table,
.signature-table tr,
.signature-table td {
	border: none !important;
	/* border: 1px solid #000;*/
}


/* Dua kolom sama besar */

.signature-table td {
    /*border: 1px solid #000;*/
    width: 95mm;

    padding: 0;
    margin: 0;

    text-align: center;

    vertical-align: top;

    font-size: 11pt;
}


/* =====================================================
   BARIS PERTAMA
   ===================================================== */

.signature-row-1 {
    height: 27mm;
}


/* =====================================================
   BARIS KEDUA
   ===================================================== */

.signature-row-2 {
    height: 30mm;
}


/* =====================================================
   RUANG UNTUK TANDA TANGAN
   ===================================================== */

.signature-space {
    height: 18mm;
}
.ttd-area {
    height: 18mm;
}
.jabatan-ttd {
    vertical-align: bottom;
    font-weight: bold;
}
.nama-ttd {
    vertical-align: bottom;
}


/* Nama jangan sampai berubah posisi */

.signature-name {
    white-space: nowrap;
}

        /* =========================
           PRINT
        ========================== */

        @media print {
            body {
                background: #fff;
            }

            .page {
                width: 100%;
                min-height: auto;
            }
        }
    </style>

<page backtop="47mm" backbottom="10mm" backleft="4mm" backright="5mm">
    <page_header style="margin-top:-5mm">
        <!-- =====================================================
     KOP SURAT GKP JEMAAT KAMPUNG SAWAH
     Lebar area: 180 mm
     ===================================================== -->
		<table class="kop-surat">
		    <tr>
		        <td style="vertical-align: top; inborder: 1px #000 solid;">
		            <img src="<?= FCPATH ;?>assets/images/logo-gkp.png" class="kop-logo">
		        </td>
		        <!-- =========================
		             INFORMASI GEREJA
		             ========================= -->
		        <td class="kop-info">
		            <div class="kop-nama-gereja">
		                GEREJA KRISTEN PASUNDAN
		            </div>
		            <div class="kop-pgi">
		                ANGGOTA PERSEKUTUAN GEREJA-GEREJA DI INDONESIA (PGI)
		            </div>
		            <div class="kop-nama-jemaat">
		                JEMAAT KAMPUNG SAWAH
		            </div>
		            <table class="kop-detail">
		                <tr>
		                    <td class="detail-label">
		                        Alamat
		                    </td>
		                    <td class="detail-colon">
		                        :
		                    </td>
		                    <td>
		                        Jl. Raya Kampung Sawah, RT 003/04
		                        No.33 - Kel. Jatimelati, Kec. Pondok Melati,
		                        Kota Bekasi 17446
		                    </td>
		                </tr>
		                <tr>
		                    <td class="detail-label">
		                        Kantor Sinode
		                    </td>
		                    <td class="detail-colon">
		                        :
		                    </td>
		                    <td>
		                        Jl. Dewi Sartika No. 119, Bandung Kode Pos 40252
		                        - Telp. (022) 5208723
		                        Faxmile : (022) 5208723
		                    </td>
		                </tr>
		                <tr>
		                    <td class="detail-label">
		                        Badan Hukum
		                    </td>
		                    <td class="detail-colon">
		                        :
		                    </td>
		                    <td>
		                        Keputusan Pemerintah No. 15, Tgl. 8 - 4 - 1936, Lembaran Negara No. 176, Tgl. 17 - 4 - 1936
		                    </td>
		                </tr>
		                <tr>
		                    <td  colspan="3">
		                        Surat Keterangan Dirjen Bimbingan Masyarakat Kristen
		                        Dept. Agama No. Dd / P / VII / 72 / 807 / 70, Tgl. 30 - 10 - 1970
		                    </td>
		                </tr>
		                <tr>
		                    <td colspan="3">
		                        Surat Keputusan Dirjen Bimbingan Masyarakat Kristen (Protestan) Departemen Agama Nomor 9 Tanggal 27 Januari 1999
		                    </td>
		                </tr>
		            </table>
		        </td>
		    </tr>
		    <!-- =========================
		         GARIS KOP
		         ========================= -->
		    <tr>
		        <td colspan="2" class="kop-garis">
		            <div class="garis-atas"></div>
		            <div class="garis-bawah"></div>
		        </td>
		    </tr>
		</table>
    </page_header>
    <page_footer>
        <table style="width: 100%; inborder: solid 1px black;">
            <tr>
                <td style="text-align: right;    width: 100%">Halaman [[page_cu]] <!--[[page_cu]]/[[page_nb]]--></td>
            </tr>
        </table>
    </page_footer>

	<div class="page">
	    <!-- =========================
	         TUJUAN SURAT
	    ========================== -->

	    <div class="tujuan">

	        <div>Kepada</div>
	        <div>Yth. Bapak/Ibu/Sdr./i</div>
	        <div>Anggota Jemaat Teritorial <?=$kwg_wil;?> (<?=$angkaID[$kwg_wil];?>)</div>
	        <div class="nama">
	            <?=$kwg_nama;?>
	        </div>

	        <div class="hal">
	            Hal : Pemberitahuan
	        </div>

	    </div>


	    <!-- =========================
	         PEMBUKA
	    ========================== -->

	    <p class="paragraph">
	    	<br>
	        <i><b>Salam Dalam Tuhan Yesus Kristus.</b></i>
	    </p>

	    <div class="table-wrapper">
		    <p class="paragraph" style="text-indent: 10mm;">
		        Sesuai dengan Pedoman Peraturan Pemakaman GKP Jemaat Kampung Sawah tentang Pedomanan Pelaksanaan Pemakaman Untuk Anggota Jemaat GKP Kampung Sawah yang sudah menjadi anggota Komisi Pelayanan Kedukaan dan Pemakaman (KPKP), dengan ini diberitahukan terkait <b>Iuran Wajib Anggota KPKP</b> periode sampai dengan bulan <b><?=$bulanID[date('n')];?> <?=date('Y');?></b> :
		    </p>
		</div>


	    <!-- =========================
	         TABEL IURAN
	    ========================== -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:7mm;">No</th>
                    <th style="width:59mm;">
                        Nama KK
                    </th>
                    <th style="width:7mm">
                        Ter
                    </th>
                    <th style="width:28mm">
                        Iuran Wajib Per Bulan (Rp)
                    </th>
                    <th style="width:28mm">
                        Jumlah Bulan (Terbayakan)
                    </th>
                    <th style="width:28mm">
                        Nominal di Sisfo (Rp)
                    </th>

                    <th style="width:28mm">
                        Nominal di Buku Besar (Rp)
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="center">
                        1
                    </td>

                    <td style="padding-left: 5px;">
                        <?=$kwg_nama;?><br>(<?=$num_anggotaKPKP;?> Jiwa)
                    </td>

                    <td class="center">
                        <?=$kwg_wil;?>
                    </td>

                    <td class="center">
                        <?=number_format($total_biayaKPKP,0,",",".");?>
                    </td>

                    <td class="center">
                        <?=$est_bulanTercover['num_month'];?><br>(<?=$est_bulanTercover['month'];?>)
                    </td>

                    <td class="center">
                        <?=number_format($saldo_akhir,0,",",".");?>
                    </td>

                    <td class="center">
                        V
                    </td>
                </tr>
            </tbody>
        </table>


	    <!-- =========================
	         PARAGRAF PEMBAYARAN
	    ========================== -->
		<br>
	    <p class="paragraph">
	        Diharapkan agar dapat melaksanakan kewajiban iurannya sesuai Pedoman Peraturan Pemakaman yang berlaku, hal ini diberitahukan untuk menghindari sanksi-sanksi ketika terjadi peristiwa kedukaan. Bagi Bapak/Ibu/Sdr./i yang ingin memenuhi kewajiban iuran dapat melakukan pembayaran melalui
	        <span class="payment-info">
	            transfer ke Bank BRI dengan No. Rekening 052701000322567 an.
	            GKP Kampung Sawah (dengan menulis berita "Iuran Wajib KPKP" an. ........)
	        </span>
	    </p>


	    <!-- =========================
	         PENUTUP
	    ========================== -->

	    <p class="closing">
	        Demikian pemberitahuan ini disampaikan, agar menjadi perhatian
	        Bapak/Ibu/Sdr./i anggota KPKP, apabila Bapak/Ibu/Sdr./i sudah
	        melaksanakan kewajiban iurannya, surat pemberitahuan ini dapat
	        diabaikan. Untuk informasi lebih lanjut dapat menghubungi pengurus
	        KPKP GKP Jemaat Kampung Sawah. Terima Kasih,
	        Tuhan Yesus Memberkati.
	    </p>


	<!-- =================================================
	     JUDUL TANDA TANGAN
	     ================================================= -->

		<div class="signature-title" instyle="border: 1px #000 solid;">

		    Komisi Pelayanan Kedukaan dan Pemakaman<br>

		    Gereja Kristen Pasundan Jemaat Kampung Sawah

		</div>


		<!-- =================================================
		     TANDA TANGAN
		     ================================================= -->
		<table class="signature-table">
		    <tr class="signature-row-1">
		        <td class="jabatan-ttd">
		            Ketua I,
		        </td>
		        <td class="jabatan-ttd">
		            Sekretaris I
		        </td>
		    </tr>
		     <tr class="signature-row-1">
		        <td class="ttd-area">
		        	<!-- TTD AREA -->
		        </td>
		        <td class="ttd-area">
		        	<!-- TTD AREA -->
		        </td>
		    </tr>
		    <tr class="signature-row-1">
		        <td class="nama-ttd">
		        	______________________________<br>
		        	Imanuel Idris
		        </td>
		        <td class="nama-ttd">
		        	______________________________<br>
		        	Rossiana Yuanita Lampung
		        </td>
		    </tr>
		    <tr class="">
		        <td>
		        	&nbsp;
		        </td>
		        <td>
		        	&nbsp;
		        </td>
		    </tr>
		    <tr class="signature-row-2">
		        <td class="jabatan-ttd">
		            Ketua Bidang II
		        </td>
		        <td class="jabatan-ttd">
		            Mengetahui,<br>
		            Penatua Koordinator KPKP
		        </td>
		    </tr>
		    <tr class="signature-row-2">
		        <td class="ttd-area">
		        	<!-- TTD AREA -->
		        	&nbsp;
		        </td>
		        <td class="ttd-area">
		        	<!-- TTD AREA -->
		        	&nbsp;
		        </td>
		    </tr>
		    <tr class="signature-row-2">
		        <td class="nama-ttd">
		        	______________________________<br>
	                Pdt. Dina Esterina, S.Si
		        </td>
		        <td class="nama-ttd">
		        	______________________________<br>
	                Viktor Talumepa
		        </td>
		    </tr>
		</table>
	</div>
</page>
<page backtop="10mm" backbottom="0mm" backleft="-3mm" backright="0mm">
	<page_footer>
        <table style="width: 100%; inborder: solid 1px black;">
            <tr>
                <td style="text-align: right;    width: 100%">Halaman [[page_cu]] <!--[[page_cu]]/[[page_nb]]--></td>
            </tr>
        </table>
    </page_footer>
	<img src="<?= FCPATH ;?>pdf7/content/Contoh Surat Pemberitahuan-1_001-150.jpg" style="width:205mm">
</page>