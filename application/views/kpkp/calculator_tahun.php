<form action="<?=base_url();?>Data_Blok_Makam/calculator_tahun" method="GET">
  <div class="form-group">
    <label>Tahun Tertampung</label>
    <input name="tahun" value=<?=$this->input->get('tahun');?>>
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
if(isset($tahun)){
?>
<?php
$current_Year=date('Y');
$sts_keanggotaan=$this->input->get('sts_keanggotaan');
$tahun=$tahun;
$data=array();
$arr_pokok_iuran=array();
$total_saldo=0;
    if($tahun < $current_Year){
        ?>
        <ol>
        <?php            
        //ini untuk yg nunggak bearti
        while ($tahun<$current_Year) {
            // code...
            $tahun++;
            $cur_iruran=0;
            foreach ($pokok_iuran_all as $key => $value) {
                // code...
                if($tahun>=$value->tahun_iuran){
                    if($sts_keanggotaan==1){
                        $cur_iruran=$value->nilai_iuran_angjem * -1;
                    }else{
                        $cur_iruran=$value->nilai_iuran_non * -1;
                    }
                    #break;
                }
            }
            $total_saldo=$total_saldo+$cur_iruran;
        ?>
          <li><?=$tahun;?> <-----> <?=$total_saldo;?> <-----> <?= number_format($cur_iruran, 2, ',', '.');?></li>  
        <?php
        }
        ?>
        <li>Total Saldo: <?=number_format($total_saldo, 2, ',', '.');?></li>
        </ol>
<?php 
    }
    else{
        //ini bearti tahunnya lebih besar tahun berjalan, ada saldo simnpanan
        ?>
        <ol>
        <?php  
        while ($tahun>$current_Year) {
             // code...
            $cur_iruran=0;
            foreach ($pokok_iuran_all as $key => $value) {
                // code...
                if($tahun>=$value->tahun_iuran){
                    if($sts_keanggotaan==1){
                        $cur_iruran=$value->nilai_iuran_angjem;
                    }else{
                        $cur_iruran=$value->nilai_iuran_non;
                    }
                    #break;
                }
            }
            $total_saldo=$total_saldo+$cur_iruran;
        ?>
          <li><?=$tahun;?> <-----> <?=$total_saldo;?> <-----> <?= number_format($cur_iruran, 2, ',', '.');?></li>  
        <?php
            $tahun--;
        }
        ?>
        <li>Total Saldo: <?=number_format($total_saldo, 2, ',', '.');?></li>
        </ol>
<?php
    }
}
?>



<?php 
if(isset($tahun)){
$tahun=$this->input->get('tahun');
?>
<?php
$current_Year=date('Y');
$sts_keanggotaan=$this->input->get('sts_keanggotaan');
$tahun=$tahun;
$data=array();
$arr_pokok_iuran=array();
$total_saldo=0;
#echo $current_Year;
#echo $tahun;
    if($current_Year > $tahun){
        ?>
        <ol>
        <?php            
        //ini untuk yg nunggak bearti
        while ($current_Year > $tahun) {
            // code...
            $cur_iruran=0;
            foreach ($pokok_iuran_all as $key => $value) {
                // code...
                if($current_Year>=$value->tahun_iuran){
                    if($sts_keanggotaan==1){
                        $cur_iruran=$value->nilai_iuran_angjem * -1;
                    }else{
                        $cur_iruran=$value->nilai_iuran_non * -1;
                    }
                    #break;
                }
            }
            $total_saldo=$total_saldo+$cur_iruran;
        ?>
          <li><?=$current_Year;?> <-----> <?=$total_saldo;?> <-----> <?= number_format($cur_iruran, 2, ',', '.');?></li>  
        <?php
            $current_Year--;
        }
        ?>
        <li>Total Saldo: <?=number_format($total_saldo, 2, ',', '.');?></li>
        </ol>
<?php 
    }
    else{
        //ini bearti tahunnya lebih besar tahun berjalan, ada saldo simnpanan
        ?>
        <ol>
        <?php  
        while ($current_Year < $tahun) {
             // code...
            $cur_iruran=0;
            foreach ($pokok_iuran_all as $key => $value) {
                // code...
                if($current_Year>=$value->tahun_iuran){
                    if($sts_keanggotaan==1){
                        $cur_iruran=$value->nilai_iuran_angjem;
                    }else{
                        $cur_iruran=$value->nilai_iuran_non;
                    }
                    #break;
                }
            }
            $total_saldo=$total_saldo+$cur_iruran;
        ?>
          <li><?=$current_Year;?> <-----> <?=$total_saldo;?> <-----> <?= number_format($cur_iruran, 2, ',', '.');?></li>  
        <?php
            $current_Year++;
        }
        ?>
        <li>Total Saldo: <?=number_format($total_saldo, 2, ',', '.');?></li>
        </ol>
<?php
    }
}
?>