      <div class="container-fluid">

        <button class="btn btn-icon btn-danger" style="position: fixed;bottom: 0;right: 0;border-radius: 50%;width: 60px;height: 60px;font-size: 1.5em;padding: unset;" data-toggle="modal" data-target="#kotakPesanModal"><i class="ni ni-email-83"></i></button>

      <!-- Footer -->

        <footer class="footer pt-0">

          <div class="row align-items-center justify-content-lg-between">

            <div class="col-lg-6">

              <div class="copyright text-center  text-lg-left  text-muted">

              	<small>Ver. 1 Beta</small>

              	<br>

                &copy; <?=date('Y');?> <a href="https://gkpkampungsawah.org/" class="font-weight-bold ml-1" target="_blank">GKP Kampung Sawah</a>

              </div>

            </div>

            <div class="col-lg-6">

              <ul class="nav nav-footer justify-content-center justify-content-lg-end">

                <li class="nav-item">

                  <!--<a href="https://kedaikite.gkpkampungsawah.org/" class="nav-link" target="_blank"><i class="ni ni-bag-17"></i> Kedai Kite</a>-->

                </li>

              </ul>

            </div>

          </div>

        </footer>

      </div>

    </div>

    <!-- open DIV ini ada di header.php               Point A -->

    <!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="9" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content" id="div_modal_content">

    </div>

  </div>

</div>



<div class="modal fade" id="kotakPesanModal" tabindex="9" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content" id="div_modal_kotakPesanModal">

      <div class=" col-sm-12">

        <h3>Kotak Pesan</h3>

        <form id="form_pesan">

          <div class="form-group">

            <?php 
            if(isset($this->session->userdata('sess_keluarga')->kwg_nama)){
            ?>  
            <input type="text" class="form-control" id="txt_keluarga" name="txt_keluarga" placeholder="Keluarga" value="<?=$this->session->userdata('sess_keluarga')->kwg_nama;?>" readonly>
            <?php 
            }else{
            ?>
              <input type="text" class="form-control" id="txt_keluarga" name="txt_keluarga" placeholder="Keluarga" value="" placeholder="Nama Keluarga Anda...">
            <?php 
            }
            ?>

            <label for="txt_pengguna">Pengguna</label>

            <input type="text" class="form-control" id="txt_pengguna" name="txt_pengguna" placeholder="Pengguna" value="">

          </div>

          <div class="form-group">

            <label for="pesan">Pesan</label>

            <textarea class="form-control" id="pesan" name="pesan" placeholder="Ketikan Pesan Anda!"></textarea>

          </div>

          <div class="btn btn-warning" id="kirimPesan">Kirim Pesan</div>

        </form>

      </div>

    </div>

  </div>

</div>



<div id="loading" class="row">

  <div class="" style="position: fixed; background:rgba(0, 0, 0, 0.5); z-index:9999; width:100%; height:100%; left:0; top:0; text-align:center;">

    <i class="fa fa-circle-o-notch fa-spin fa-3x" style="margin-top:200px; color: #fff;" aria-hidden="true" ></i>

  </div>

</div>





    <!-- Argon Scripts -->

    <!-- Core -->

    <script src="<?=base_url();?>assets/frontend/vendor/jquery/dist/jquery.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/js-cookie/js.cookie.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>

    <!-- Optional JS -->

    <script src="<?=base_url();?>assets/frontend/vendor/chart.js/dist/Chart.min.js"></script>

    <script src="<?=base_url();?>assets/frontend/vendor/chart.js/dist/Chart.extension.js"></script>

    <!-- Argon JS -->

    <script src="<?=base_url();?>assets/frontend/js/argon.js?v=1.2.0"></script>



    <!-- fancybox.js-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>



  <script src="<?=base_url();?>assets/frontend/vendor/sweetmodal/js/jquery.sweet-modal.min.js"></script>

    



    <script type="text/javascript">

      $(document).on('click', '[id=btn_ajax_modal]', function(e){

        e.preventDefault();

        dataMap={}

        href=$(this).attr('href');

        $.post(href, dataMap, function(data){

          $('#div_modal_content').html(data)

        })

      })



      $(document).ready(function(){

        $('#loading').hide();

      })



      $(document).on('click', '[id=kirimPesan]', function(e){

        dataMap={};

        dataMap=$('#form_pesan').serialize();

        $.post('<?=base_url();?>/ajax/kirimPesan', dataMap, function(data){

          $('#kotakPesanModal').modal('hide')

          $('#txt_pengguna').val('')

          $('#pesan').val('')

        })

      })



      function Pemiluclose(title){

        console.log("sdadasd");

          $.sweetModal({

            content: title,

            icon: $.sweetModal.ICON_ERROR,

            timeout: 7000

          });

          /*setTimeout(function(){

            window.location.href = "<?=base_url();?>beranda";

          }, 1500);*/

      }

      function Pemiluopen(title){

          $.sweetModal({

            content: title,

            icon: $.sweetModal.ICON_SUCCESS,

            timeout: 7000

          });

          /*setTimeout(function(){

            window.location.href = "<?=base_url();?>beranda";

          }, 1500);*/

      }

    </script>

    

    <!-- izy Toastt-->

    <script src="<?= base_url('assets/iziToast-master/dist/js/iziToast.js'); ?>"></script>



    <script type="text/javascript">

      function scriptCountDown(StringTime, dom='timer', close=null, open=0){

        const second = 1000,

        minute = second * 60,

        hour = minute * 60;

        day = hour * 24;

        var Waktu=""
        i0=0;
    let countDown = new Date(StringTime).getTime(),

        x = setInterval(function() {

            let now = new Date().getTime(),

                distance = countDown - now;

              if(distance>0){

                  Hari= Math.floor((distance) / (day))+"<span style='font-size:0.65rem;'>Hari</span> ",

                  Jam =Math.floor((distance) % (day) / (hour))+"<span style='font-size:0.65rem;'>Jam</span> ",

                  Menit =Math.floor((distance) % (hour) / (minute))+"<span style='font-size:0.65rem;'>Menit</span> ",

                  Detik =Math.floor((distance % (minute)) / second)+"<span style='font-size:0.65rem;'>Detik</span>";

                  //document.getElementById('hours').innerText = Math.floor((distance) / (hour)),

                  //document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),

                  //document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

              }

              else{

                  Hari = '0 Hari'

                  Jam = '0 Jam',

                  Menit = '0 Menit',

                  Detik = '0 Detik'; 
//                  console.log(close+" asdas")
                  //console.log(open+" ooo")
                  if(close=='' && open==0){
                    setTimeout(function(){location.reload()},700)
                  }
                  if(close==''){

                    //setTimeout(function(){

                      location.reload();

                   // },1500)

                  }

                  i0++;
                  if(i0>2){
                    clearInterval(x);
                  }

              }



              Waktu=Hari+" "+Jam+" "+Menit+" "+Detik

              document.getElementById(dom).innerHTML =Waktu

          //  'IT'S MY BIRTHDAY!;

    }, second);

      }

    </script>



  </body>

</html>