<!-- footer content -->

        <footer>

          <div class="pull-right">

            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>

<!--loading page-->

    <div id="loading" class="row">

        <div class="col s12 center" style="position: fixed; background:rgba(0, 0, 0, 0.5); z-index:9999; width:100%; height:100%; left:0; top:0; text-align:center;">

                <i class="fa fa-circle-o-notch fa-spin fa-5x" style="margin-top:20%; color: #fff;" aria-hidden="true" ></i>

        </div>

    </div>

<!--loading page-->



<!-- frame modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="myModal">

    <div class="modal-dialog  modal-lg" role="document">

        <div class="modal-content" id="modal-content">

        </div>

    </div>

</div>

<!-- frame modal -->

<!-- frame modal2 -->

<div class="modal fade" tabindex="-1" role="dialog" id="myModal2">

    <div class="modal-dialog  modal-lg" role="document">

        <div class="modal-content" id="modal-content2">

        </div>

    </div>

</div>

<!-- frame modal2 -->



    <!-- Bootstrap -->

    <script src="<?=base_url();?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- FastClick -->

    <script src="<?=base_url();?>/vendors/fastclick/lib/fastclick.js"></script>

    <!-- NProgress -->

    <script src="<?=base_url();?>/vendors/nprogress/nprogress.js"></script>

    <!-- Chart.js -->

    <script src="<?=base_url();?>/vendors/Chart.js/dist/Chart.min.js"></script>

    <!-- gauge.js -->

    <script src="<?=base_url();?>/vendors/gauge.js/dist/gauge.min.js"></script>

    <!-- bootstrap-progressbar -->

    <script src="<?=base_url();?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

    <!-- iCheck -->

    <script src="<?=base_url();?>/vendors/iCheck/icheck.min.js"></script>

    <!-- Skycons -->

    <script src="<?=base_url();?>/vendors/skycons/skycons.js"></script>

    <!-- Flot -->

    <script src="<?=base_url();?>/vendors/Flot/jquery.flot.js"></script>

    <script src="<?=base_url();?>/vendors/Flot/jquery.flot.pie.js"></script>

    <script src="<?=base_url();?>/vendors/Flot/jquery.flot.time.js"></script>

    <script src="<?=base_url();?>/vendors/Flot/jquery.flot.stack.js"></script>

    <script src="<?=base_url();?>/vendors/Flot/jquery.flot.resize.js"></script>

    <!-- Flot plugins -->

    <script src="<?=base_url();?>/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>

    <script src="<?=base_url();?>/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>

    <script src="<?=base_url();?>/vendors/flot.curvedlines/curvedLines.js"></script>

    <!-- DateJS -->

    <script src="<?=base_url();?>/vendors/DateJS/build/date.js"></script>

    <!-- JQVMap -->

    <script src="<?=base_url();?>/vendors/jqvmap/dist/jquery.vmap.js"></script>

    <script src="<?=base_url();?>/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <script src="<?=base_url();?>/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>

    <!-- bootstrap-daterangepicker -->

    <!--<script src="<?=base_url();?>/vendors/moment/min/moment.min.js"></script>

    <script src="<?=base_url();?>/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>-->



    <!-- bootstrap-datepicker -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- NProgress -->
    <script src="<?=base_url();?>vendors/nprogress/nprogress.js"></script>
    <!-- Dropzone.js -->
    <script src="<?=base_url();?>vendors/dropzone/dist/dropzone.js?v=<?=microtime();?>"></script>

    <!-- Switchery -->
    <script src="<?=base_url();?>vendors/switchery/dist/switchery.min.js"></script>



    <!-- Custom Theme Scripts -->

    <script src="<?=base_url();?>/build/js/custom.js?version=3"></script>
    <!--<script src="<?=base_url();?>/build/js/pagination.js"></script>-->





    <script type="text/javascript">

        $(document).ready(function(){

            $('#loading').hide();

        })

        $(document).on('click touchstart', '[id=btn-formuploadlampiran]', function(e){
            e.preventDefault()
            dataMap={}
            dataMap['no_anggota']=$(this).attr('noAnggota')
            dataMap['nama_anggota']=$(this).attr('namaAnggota')
            url=$(this).attr('href')
            $('#myModal2').modal('show')
            $.post(url, dataMap, function(data){
                $('#modal-content2').html(data)
                setTimeout(function(){
                    load_lampiran_angjem()
                }, 500)
            })
        })

        $(document).on('click', '[id=add_item]', function(e){

            e.preventDefault();

            dataMap={};

            num_item_added=$('#num_item_added').val();

            num_item_added=parseInt(num_item_added)+1;

            $('#item_sj > tbody:last-child').append(data);

            $('#num_item_added').val(num_item_added);

            $('#ls_barang_cabang').val(0)

        })



        $(document).on('click', '.confirm', function(e){

            e.preventDefault();

            msg=$(this).attr('msg');

            href=$(this).attr('href');

            var notif = confirm(msg);

            if (notif == true) {

              window.location.href = href;

            } 

        })



        $(document).on('click', '[class^=reset]', function(e){

            e.preventDefault();

            msg=$(this).attr('msg');

            what=$(this).attr('what');

            var notif = confirm(msg);

            if (notif == true) {

                if(what=='date'){

                    $(this).parent('span').parent('div').find('.datepicker').val('00-00-0000');

                }

            } 

        })

        function get_pertumbuhanJemaat(tahun='<?=date('Y');?>' ) {
        $('#loading_grap1').show();
        dataMap={}
        dataMap['type']='json';
        dataMap['group']='month';
        dataMap['tahun']=tahun;
        $.post('<?=base_url();?>ajax/get_pertumbuhanJemaat', dataMap, function(data){
            json=$.parseJSON(data);
            dataChart={}
            dataChart['meninggal']=json.meninggal;
            dataChart['lahir']=json.lahir;
            dataChart['labels']=json.labels;

            var ctx = document.getElementById("lineChart");
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataChart['labels'],
                    datasets: [{
                        label: "Data Kematian",
                        backgroundColor: "rgba(255, 238, 99, 0.31)",
                        borderColor: "rgba(255, 238, 99, 0.7)",
                        pointBorderColor: "rgba(255, 238, 99, 0.7)",
                        pointBackgroundColor: "rgba(255, 238, 99, 0.7)",
                        pointHoverBackgroundColor: "#333",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointBorderWidth: 1,
                        data: dataChart['meninggal']
                    },
                    {
                        label: "Data Kelahiran",
                        backgroundColor: "rgba(84, 104, 226, 0.3)",
                        borderColor: "rgba(84, 104, 226, 0.70)",
                        pointBorderColor: "rgba(84, 104, 226, 0.70)",
                        pointBackgroundColor: "rgba(84, 104, 226, 0.70)",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(254,123,169,1)",
                        pointBorderWidth: 1,
                        data: dataChart['lahir']
                    }]
                },
            });
            $('#loading_grap1').hide();
        })
    }

    function get_pertumbuhanJemaat_perTahun(tahun='<?=date('Y');?>') {
        $('#loading_grap2').show();
        dataMap={}
        dataMap['type']='json';
        dataMap['group']='month';
        dataMap['tahun']=tahun;
        $.post('<?=base_url();?>ajax/get_pertumbuhanJemaat_perTahun', dataMap, function(data){
            json=$.parseJSON(data);
            dataChart={}
            dataChart['meninggal']=json.meninggal;
            dataChart['lahir']=json.lahir;
            dataChart['labels']=json.labels;

            var ctx = document.getElementById("lineChart_pertahun");
            var lineChart_pertahun = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataChart['labels'],
                    datasets: [{
                        label: "Data Kematian",
                        backgroundColor: "rgba(255, 238, 99, 0.31)",
                        borderColor: "rgba(255, 238, 99, 0.7)",
                        pointBorderColor: "rgba(255, 238, 99, 0.7)",
                        pointBackgroundColor: "rgba(255, 238, 99, 0.7)",
                        pointHoverBackgroundColor: "#333",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointBorderWidth: 1,
                        data: dataChart['meninggal']
                    },
                    {
                        label: "Data Kelahiran",
                        backgroundColor: "rgba(84, 104, 226, 0.3)",
                        borderColor: "rgba(84, 104, 226, 0.70)",
                        pointBorderColor: "rgba(84, 104, 226, 0.70)",
                        pointBackgroundColor: "rgba(84, 104, 226, 0.70)",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(254,123,169,1)",
                        pointBorderWidth: 1,
                        data: dataChart['lahir']
                    }]
                },
            });
            $('#loading_grap2').hide();
        })
    }

    /*$(document).on('change', '[id=ls_tahun_pertumbuhanAngJem]', function(e){
        e.preventDefault()
        tahun=$(this).val()
        get_pertumbuhanJemaat(tahun)
    })*/
    function load_lampiran_angjem() {
        dataMap={}
        dataMap['angjem_id']=$('#recid_uploadLampiran').val()
        $.post('<?=base_url();?>admin/get_lampiran_angjem', dataMap, function(data){
            $('#content_lampiran').html(data)
        })
    }

    $(document).on('click touchstart', '[id=btn_delete_lampiran]', function(e){
        e.preventDefault()
        var notif = confirm("Apakah Anda yakin ingin menghapus data Lampiran ini?");
        if (notif == false) {
          return;
        } 


        dataMap={}
        url=$(this).attr('href')
        $.post(url, dataMap, function(data){
            json=$.parseJSON(data)
            if(json.sts==1){
                load_lampiran_angjem()
            }
            else{
                iziToast.error({
                    title: "Gagal Menghapus Lampiran",
                    message: 'Silahkan hubung Administrator!',
                    position: "topRight",
                    class: "iziToast-danger",

                });
            }
        })
    })

    </script>

	

  </body>

</html>