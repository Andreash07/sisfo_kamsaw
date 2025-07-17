<form action="<?=base_url();?>Data_Blok_Makam/calculator" method="GET">
  <div class="form-group">
    <label>Nominal</label>
    <input name="nominal" value=<?=$this->input->get('nominal');?>>
  </div>
  <div class="form-group">
    <label>Sts Anggota</label>
    <select name="sts_keanggotaan">
      <option value="0" <?php if($this->input->get('sts_keanggotaan') == 0){ echo "selected";} ?>>NON GKP Kampung Sawah</option>
      <option value="1" <?php if($this->input->get('sts_keanggotaan') == 1){ echo "selected";} ?>>GKP Kampung Sawah</option>
    </select>
  </div>
  <button type="submit">Hitung</button>
</form>

<?php 
if(isset($nominal)){
?>
<?php
$current_Year=date('Y');
$sts_keanggotaan=$this->input->get('sts_keanggotaan');
$saldo=$nominal;
$data=array();
$cur_iruran=array();
$arr_pokok_iuran=array();
foreach ($pokok_iuran_all as $key => $value) {
    // code...
    $arr_pokok_iuran[$value->tahun_iuran]=$value;
    if($current_Year>=$value->tahun_iuran){
        $cur_iruran=$value;
    }
    //batas bawah tahun
}
krsort($arr_pokok_iuran);
$total_biayaKPKP=0;
if($sts_keanggotaan==1){
    $total_biayaKPKP=$cur_iruran->nilai_iuran_angjem;
}else{
    $total_biayaKPKP=$cur_iruran->nilai_iuran_non;
}
$num_tahun=floor($saldo/$total_biayaKPKP);
if($num_tahun>=0){
    #langsung seperti biasa tidak perlu hitung tahun mundur dan cek tahun iuran yg berlakunya 
    $num_tahun_tercover=floor($saldo/$total_biayaKPKP);
    $data['tahun_tercover']=date("Y",strtotime($num_tahun_tercover." year"));
    $data['num_tahun_tercover']=$num_tahun_tercover;
}
else{
   //ini untuk tahun yg kurang bayar (saldo minus)
    $saldo_positif=$saldo*-1;
    #ini num tahunnya berdasarkan hitungna mundur dari pengurangan saldo yg ada. berdasarkan pokok iuran KPKP yg berlaku.
    $num_tahun_new=0;

  ?>
  <ol>
    <li><?=$current_Year+$num_tahun_new;?> <----> <?=$saldo_positif;?> <----> <?=$total_biayaKPKP;?></li>
  <?php
  $last_current_year=$current_Year;
    while ($saldo_positif>0) {
        // code...
        $total_biayaKPKP=0;
        //cek tahun iuran pokok yg berlaku dulu
        foreach ($arr_pokok_iuran as $key1 => $value1) {
        print_r($value1); die();
            // code...
          echo $value1->tahun_iuran.' <--->'.$last_current_year;
            if($last_current_year>=$value1->tahun_iuran){
                if($sts_keanggotaan==1){
                    $total_biayaKPKP=$value1->nilai_iuran_angjem;
                }else{
                    $total_biayaKPKP=$value1->nilai_iuran_non;
                }
                break;
            }
        }
        $saldo_positif=$saldo_positif-$total_biayaKPKP;
        #if($saldo_positif>=0){
            $num_tahun_new--;
            $last_current_year=$last_current_year-1;
        #}
    ?>
      <li><?=$current_Year+$num_tahun_new;?> <----> <?=$saldo_positif;?>  <----> <?=$total_biayaKPKP;?></li>
    <?php 
    }
    #pengecekan mundur seleai baru hitung tahunnya
    $data['tahun_tercover']=date("Y",strtotime($num_tahun_new." year"));
    $data['num_tahun_tercover']=$num_tahun_new;
?>
  </ol>
<?php
}
?>

<?php 
}
?>