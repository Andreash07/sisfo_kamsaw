<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th class="text-center" style="width: 150px;">Tanggal</th>
      <th class="text-center">Transaksi</th>
      <!--<th>Jumlah Iuran</th>-->
      <th class="text-center">Nominal</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $total_mutasi=0;
      foreach ($data as $key => $value) {
        // code...
        if($value->note!=''){
          $value->note="<br><label style='font-size:9pt;'><i>Catatan:</i> ".$value->note."</label>";
        }
        switch ($value->type) {
          case '0':
            // code...
              $name="Saldo Awal";
            break;
          case '1':
            // code...
              $name="Setor Iuran ".$value->note;
            break;
          case '2':
            // code...
              $name="Pembayaran Iuran ".$value->note;
            break;
          case '3':
            // code...
              $name="Setor Sukarela".$value->note;
            break;
          case '4':
            // code...
              $name="Saldo KPKP (Keluar <i class='fa fa-minus text-danger'></i>)".$value->note;
            break;
          case '5':
            // code...
              $name="Saldo KPKP (Masuk <i class='fa fa-plus text-success'></i>)".$value->note;
            break;
          default:
            // code...
              $name="<i class='text-danger'>Tidak diketahui</i>";
            break;
        }
        if(in_array($value->type, array(0,1,2,5)) ) {
          $total_mutasi=$total_mutasi+$value->nominal;
        }
        else if(in_array($value->type, array(4)) ) {
          $total_mutasi=$total_mutasi-$value->nominal;
        }

        $nominal=number_format($value->nominal,0,",",".");
        if($value->nominal>0){
          $nominal='<span class="text-success">+'.number_format($value->nominal,0,",",".")."</span>";
        }
        else if($value->nominal<0){
          $nominal='<span class="text-danger">'.number_format($value->nominal,0,",",".")."</span>";
          if(in_array($value->type, array(4)) ) {
            $nominal='(-) '.$nominal;
          }
        }
        if($value->note!=null){
          //$value->note='<br><i>Catatan</i>: '.$value->note;
        }
    ?>
        <tr>
          <th class="text-center" scope="row"><?=$key+1;?></th>
          <td class="text-center" style="width: 150px;"><?=convert_tgl_dMY($value->tgl_bayar);?></td>
          <td style="line-height: unset;"><?=$name;?></td>
          <td class="text-right"><?=$nominal;?></td>
          <td class="text-center">
            <div class="btn btn-warning btn-sm" title="Perbaikan Mutasi" id="btn_edit-Mutasi<?=$value->id;?>" form="<?=base_url().'pemakaman/form_perbaikan?id='.$value->id;?>"><i class="fa fa-pencil"></i></div>
          </td>
        </tr>
    <?php
      }
    ?>
        <tr>
          <th colspan="3" class="text-right">Jumlah Mutasi</th>
          <th class="text-right"><?=$total_mutasi;?></th>
          <th class="text-right">
            <?php 
              if(isset($dataKpkp2->saldo_akhir) && $total_mutasi!=$dataKpkp2->saldo_akhir){
                //print_r($dataKpkp2);

            ?>
                ada perbedaan jumlah tertanggung<br>
                <div class="btn btn-danger" id="btn_approve_perbaikan" kk_id="<?=$dataKpkp2->keluarga_jemaat_id;?>" href="<?=base_url().'pemakaman/approve';?>" total_mutasi='<?=$total_mutasi;?>'>Setujui Perbaikan</div>
            <?php
              }
            ?>
          </th>
        </tr>
  </tbody>
</table>