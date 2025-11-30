<?php
$this->load->view('layout/header');
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <h2 class="col-md-7 col-sm-7 col-xs-12">Statistik Makam</h2>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel tile">
          <div class="x_title">
              <h2>Grafik Blok Makam</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div id="mainb" style="height:350px;"><i class="fa fa-circle-o-notch fa-spin fa-4x" style="margin-left:40%;"></i></div>
          </div>
      </div>
    </div>
  </div>

  <div class="row">
    <h2>Statistik Lunas/Tunggakan</h2>
    <div class="clearfix"></div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
          <div class="x_title">
              <h2>Lunas >=1Tahun [<?= count($data['>0tahun']);?>]</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="div_perolehansuara" style="max-height:500px; overflow: auto;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Blok/Kav</th>
                  <th>Nama</th>
                  <th class="text-center">Tahun Tertampung</th>
                </tr>
              </thead>
              <tbody>
            <?php
              foreach ($data['>0tahun'] as $key => $value) {
                // code...
            ?>
                <tr>
                  <td class="text-center"><?=$key+1;?></td>
                  <td class="text-center"><?=$value->blok?> <?=$value->kavling?></td>
                  <td>
                    <?=$value->penghuni_makam;?>
                    <span class="text-small"><?=$value->asal_gereja;?></span>
                  </td>
                  <td class="text-center"><?=$value->tahun_tercover?></td>
                </tr>
            <?php
              }
            ?>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
          <div class="x_title">
              <h2>Lunas Tahun <?=date('Y');?> [<?= count($data['0tahun']);?>]</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="div_perolehansuara" style="max-height:500px; overflow: auto;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Blok/Kav</th>
                  <th>Nama</th>
                  <th class="text-center">Tahun Tertampung</th>
                </tr>
              </thead>
              <tbody>
            <?php
              foreach ($data['0tahun'] as $key => $value) {
                // code...
            ?>
                <tr>
                  <td class="text-center"><?=$key+1;?></td>
                  <td class="text-center"><?=$value->blok?> <?=$value->kavling?></td>
                  <td>
                    <?=$value->penghuni_makam;?>
                    <span class="text-small"><?=$value->asal_gereja;?></span>
                  </td>
                  <td class="text-center"><?=$value->tahun_tercover?></td>
                </tr>
            <?php
              }
            ?>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
          <div class="x_title">
              <h2>Tunggakan 1-3 Tahun [<?= count($data['-3tahun']);?>]</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="div_perolehansuara" style="max-height:500px; overflow: auto;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Blok/Kav</th>
                  <th>Nama</th>
                  <th class="text-center">Tahun Tertampung</th>
                </tr>
              </thead>
              <tbody>
            <?php
              foreach ($data['-3tahun'] as $key => $value) {
                // code...
            ?>
                <tr>
                  <td class="text-center"><?=$key+1;?></td>
                  <td class="text-center"><?=$value->blok?> <?=$value->kavling?></td>
                  <td>
                    <?=$value->penghuni_makam;?>
                    <span class="text-small"><?=$value->asal_gereja;?></span>
                  </td>
                  <td class="text-center"><?=$value->tahun_tercover?></td>
                </tr>
            <?php
              }
            ?>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
          <div class="x_title">
              <h2>Tunggakan 4-5 Tahun [<?= count($data['-5tahun']);?>]</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="div_perolehansuara" style="max-height:500px; overflow: auto;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Blok/Kav</th>
                  <th>Nama</th>
                  <th class="text-center">Tahun Tertampung</th>
                </tr>
              </thead>
              <tbody>
            <?php
              foreach ($data['-5tahun'] as $key => $value) {
                // code...
            ?>
                <tr>
                  <td class="text-center"><?=$key+1;?></td>
                  <td class="text-center"><?=$value->blok?> <?=$value->kavling?></td>
                  <td>
                    <?=$value->penghuni_makam;?>
                    <span class="text-small"><?=$value->asal_gereja;?></span>
                  </td>
                  <td class="text-center"><?=$value->tahun_tercover?></td>
                </tr>
            <?php
              }
            ?>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
          <div class="x_title">
              <h2>Tunggakan 6-10 Tahun [<?= count($data['-10tahun']);?>]</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="div_perolehansuara" style="max-height:500px; overflow: auto;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Blok/Kav</th>
                  <th>Nama</th>
                  <th class="text-center">Tahun Tertampung</th>
                </tr>
              </thead>
              <tbody>
            <?php
              foreach ($data['-10tahun'] as $key => $value) {
                // code...
            ?>
                <tr>
                  <td class="text-center"><?=$key+1;?></td>
                  <td class="text-center"><?=$value->blok?> <?=$value->kavling?></td>
                  <td>
                    <?=$value->penghuni_makam;?>
                    <span class="text-small"><?=$value->asal_gereja;?></span>
                  </td>
                  <td class="text-center"><?=$value->tahun_tercover?></td>
                </tr>
            <?php
              }
            ?>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
          <div class="x_title">
              <h2>Tunggakan >10 Tahun [<?= count($data['<-10tahun']);?>]</h2>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="div_perolehansuara" style="max-height:500px; overflow: auto;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Blok/Kav</th>
                  <th>Nama</th>
                  <th class="text-center">Tahun Tertampung</th>
                </tr>
              </thead>
              <tbody>
            <?php
              foreach ($data['<-10tahun'] as $key => $value) {
                // code...
            ?>
                <tr>
                  <td class="text-center"><?=$key+1;?></td>
                  <td class="text-center"><?=$value->blok?> <?=$value->kavling?></td>
                  <td>
                    <?=$value->penghuni_makam;?>
                    <span class="text-small"><?=$value->asal_gereja;?></span>
                  </td>
                  <td class="text-center"><?=$value->tahun_tercover?></td>
                </tr>
            <?php
              }
            ?>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<?php
$this->load->view('layout/footer');
?>

<!-- ECharts -->

<script src="../vendors/echarts/dist/echarts.min.js"></script>

<script src="../vendors/echarts/map/js/world.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
console.log('asdasasdasd')
    var theme = {
        color: [
          '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
          '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
        ],
        title: {
          itemGap: 8,
          textStyle: {
            fontWeight: 'normal',
            color: '#408829'
          }
        },
        dataRange: {
          color: ['#1f610a', '#97b58d']
        },
        toolbox: {
          color: ['#408829', '#408829', '#408829', '#408829']
        },
        tooltip: {
          backgroundColor: 'rgba(0,0,0,0.5)',
          axisPointer: {
            type: 'line',
            lineStyle: {
              color: '#408829',
              type: 'dashed'
            },
            crossStyle: {
              color: '#408829'
            },
            shadowStyle: {
              color: 'rgba(200,200,200,0.3)'
            }
          }
        },
        dataZoom: {
          dataBackgroundColor: '#eee',
          fillerColor: 'rgba(64,136,41,0.2)',
          handleColor: '#408829'
        },
        grid: {
          borderWidth: 0
        },
        categoryAxis: {
          axisLine: {
            lineStyle: {
              color: '#408829'
            }
          },
          splitLine: {
            lineStyle: {
              color: ['#eee']
            }
          }
        },
        valueAxis: {
          axisLine: {
            lineStyle: {
              color: '#408829'
            }
          },
          splitArea: {
            show: true,
            areaStyle: {
              color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
            }
          },
          splitLine: {
            lineStyle: {
              color: ['#eee']
            }
          }
        },
        timeline: {
          lineStyle: {
            color: '#408829'
          },
          controlStyle: {
            normal: {color: '#408829'},
            emphasis: {color: '#408829'}
          }
        },
        k: {
          itemStyle: {
            normal: {
              color: '#68a54a',
              color0: '#a9cba2',
              lineStyle: {
                width: 1,
                color: '#408829',
                color0: '#86b379'
              }
            }
          }
        },
        map: {
          itemStyle: {
            normal: {
              areaStyle: {
                color: '#ddd'
              },
              label: {
                textStyle: {
                  color: '#c12e34'
                }
              }
            },
            emphasis: {
              areaStyle: {
                color: '#99d2dd'
              },
              label: {
                textStyle: {
                  color: '#c12e34'
                }
              }
            }
          }
        },
        force: {
          itemStyle: {
            normal: {
              linkStyle: {
                strokeColor: '#408829'
              }
            }
          }
        },
        chord: {
          padding: 4,
          itemStyle: {
            normal: {
              lineStyle: {
                width: 1,
                color: 'rgba(128, 128, 128, 0.5)'
              },
              chordStyle: {
                lineStyle: {
                  width: 1,
                  color: 'rgba(128, 128, 128, 0.5)'
                }
              }
            },
            emphasis: {
              lineStyle: {
                width: 1,
                color: 'rgba(128, 128, 128, 0.5)'
              },
              chordStyle: {
                lineStyle: {
                  width: 1,
                  color: 'rgba(128, 128, 128, 0.5)'
                }
              }
            }
          }
        },
        gauge: {
          startAngle: 225,
          endAngle: -45,
          axisLine: {
            show: true,
            lineStyle: {
              color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
              width: 8
            }
          },
          axisTick: {
            splitNumber: 10,
            length: 12,
            lineStyle: {
              color: 'auto'
            }
          },
          axisLabel: {
            textStyle: {
              color: 'auto'
            }
          },
          splitLine: {
            length: 18,
            lineStyle: {
              color: 'auto'
            }
          },
          pointer: {
            length: '90%',
            color: 'auto'
          },
          title: {
            textStyle: {
              color: '#333'
            }
          },
          detail: {
            textStyle: {
              color: 'auto'
            }
          }
        },
        textStyle: {
          fontFamily: 'Arial, Verdana, sans-serif'
        }
      };


    var blok_makam=[]
    var data_blok_i=[]

    dataMap={}

    $.post('<?=base_url();?>ajax/rincian_makam', dataMap, function(data){

      json=$.parseJSON(data)
      blok_makam=json.blok
      console.log(blok_makam)
      console.log(json.data_blok)
      
      for(var i in json.data_blok){
         // num_kavling.push(json.num_pesertaPemilihan[i]*kuota_suara);
          data_blok_i.push(json.data_blok[i]); //ini murni pesertanya belum di * kuota suara
      }



        //for(var j in json.num_suaraDikunci)

          //suaraDikunci.push(json.num_suaraDikunci[j]);



        ///for(var k in json.num_BelumDikunci)

          //suaraBelumDikunci.push(json.num_BelumDikunci[k]);

      echart1(blok_makam, data_blok_i );


      //pieChart('echart_pie_global', json.num_pesertaPemilihan_global*kuota_suara, json.num_suaraDikunci_global, json.num_BelumDikunci_global, 'Perolehan Suara Total', json.pesertaPemilihan_dikunci_global, json.pesertaPemilihan_belumkunci_global)
    })





    function echart1(blok_makam, data_blok_i ){
//console.log(echart1+'asdasd')
      
      if ($('#mainb').length ){

          var echartBar = echarts.init(document.getElementById('mainb'), theme);

          console.log(data_blok_i)

          echartBar.setOption({

          title: {

           // text: 'Graph title',

            //subtext: 'Graph Sub-text'

          },

          tooltip: {

            trigger: 'axis'

          },

          legend: {

            data: ['Total Kavling']

          },

          toolbox: {

            show: false

          },

          calculable: false,

          xAxis: [{

            type: 'category',

            data: blok_makam

          }],

          yAxis: [{

            type: 'value'

          }],

          series: [{

            name: 'Total Kavling',

            type: 'bar',

            data: data_blok_i,

            markPoint: {

            data: [{

              type: 'max',

              name: 'Terbanyak'

            },

            {

              type: 'min',

              name: 'Terendah'

            }]

            },

          }//, {

            //name: 'Suara Sah',

            //type: 'bar',

            //data: suaraDikunci,

            //markPoint: {

            //data: [{

              //type: 'max',

              //name: 'Terbanyak'

            //},

            //{

              //type: 'min',

              //name: 'Terendah'

            //}]

            //},

          //},

          //{

            //name: 'Suara Belum Dikunci',

            //type: 'bar',

            //data: suaraBelumDikunci,

            //markPoint: {

            //data: [{

              //type: 'max',

              //name: 'Terbanyak'

            //},

            //{

              //type: 'min',

              //name: 'Terendah'

            //}]

            //},

          //}
          ]

          });

      }
      $('#mainb').append('<div class="col-xs-12 text-center"><i class="text-sm text-danger">&nbsp;</div>')

    }





    function pieChart(dom, peserta=0, suaradikunci=0, suarabelumdikunci=0, namePie, pesertaDikunci=0,  pesertaBelumDikunci=0){

      console.log(dom);

      var theme1 = {

        color: [

          '#ba4d4d', '#34495E', '#BDC3C7', '#3498DB',

          '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'

        ]}



      if ($('#'+dom).length ){  

        belummemlih=parseInt(peserta) - (parseInt(suaradikunci)+parseInt(suarabelumdikunci))

        var echartPie = echarts.init(document.getElementById(dom), theme1);

        real_peserta=peserta/8;

        console.log(namePie+pesertaDikunci)
        console.log(namePie+pesertaBelumDikunci)
        num_pesertaMemilih='';
        lbl_persent_pesertaMemilih='';
        //if(namePie !='Perolehan Suara Total'){
          num_pesertaMemilih=parseInt(pesertaDikunci)+parseInt(pesertaBelumDikunci)
          persent_pesertaMemilih=(num_pesertaMemilih/real_peserta*100).toFixed(2);
          lbl_persent_pesertaMemilih=num_pesertaMemilih+' ('+String(persent_pesertaMemilih)+' %)';
          
          persent_suaraMemilih=((parseInt(suaradikunci)+parseInt(suarabelumdikunci))/peserta*100).toFixed(2);
        //}

        echartPie.setOption({

          title: {

            text: 'Peserta Pemilihan '+real_peserta+'\n'+lbl_persent_pesertaMemilih+' Sudah Memilih',

            subtext: 'Suara '+peserta+' (x8 @1Peserta)'

          },

        tooltip: {

          trigger: 'item',

          formatter: "{a} <br/>{b} : {c} ({d}%)"

        },

        legend: {

          x: 'center',

          y: 'bottom',

          data: ['Suara Belum Digunakan', 'Suara Sah', 'Suara Belum Dikunci']

        },

        toolbox: {

          show: true,

          feature: {

          magicType: {

            show: true,

            type: ['pie', 'funnel'],

            option: {

            funnel: {

              x: '25%',

              width: '50%',

              funnelAlign: 'left',

              max: 1548

            }

            }

          },

          restore: {

            show: true,

            title: "Restore"

          },

          saveAsImage: {

            show: true,

            title: "Save Image"

          }

          }

        },

        calculable: true,

        series: [{

          name: namePie,

          type: 'pie',
          label:{

            normal: {

              alignTo: 'line',

              formatter: '{b}\n{c}\n({d}%)',

              position: 'outside',

              minMargin: 5,

              edgeDistance: 10,

              lineHeight: 15,

            } 

          },

          radius: '55%',

          center: ['50%', '55%'],

          data: [{

          value: suarabelumdikunci,

          name: 'Suara Belum Dikunci'

          }, {

          value: suaradikunci,

          name: 'Suara Sah'

          }, {

          value: belummemlih,

          name: 'Suara Belum Digunakan'

          }]

        }]

        });



        var dataStyle = {

        normal: {

          label: {

          show: false

          },

          labelLine: {

          show: false

          }

        }

        };



        var placeHolderStyle = {

        normal: {

          color: 'rgba(0,0,0,0)',

          label: {

          show: false

          },

          labelLine: {

          show: false

          }

        },

        emphasis: {

          color: 'rgba(0,0,0,0)'

        }

        };



      } 

    }

  })

function copyDiv(domId) {
    var content = document.getElementById(domId).innerText;

    navigator.clipboard.writeText(content).then(function() {
        // Bisa diganti pakai alert Bootstrap
        alert("Teks berhasil disalin ke clipboard!");
    }, function(err) {
        console.error("Gagal menyalin: ", err);
    });
}

</script>

