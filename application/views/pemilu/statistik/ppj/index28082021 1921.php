<?php

$this->load->view('layout/header');

?>

<!-- page content -->

<div class="right_col" role="main">
  	<h2>Statistik Perolehan Suara - PPJ</h2>
	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12">
	      	<div class="x_panel tile">
	            <div class="x_title">
	              	<h2>Suara Pemilihan PPJ - Wilayah</h2>
	              	<div class="clearfix"></div>
	            </div>
              	<div class="x_content">
	                <div id="mainb" style="height:350px;"><i class="fa fa-circle-o-notch fa-spin fa-4x" style="margin-left:40%;"></i></div>
	            </div>
      		</div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Suara Pemilihan PPJ</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div id="echart_pie_global" style="height:350px;"><i class="fa fa-circle-o-notch fa-spin fa-4x" style="margin-left:40%;"></i></div>
              </div>
            </div>
      	</div>
	</div>
	<div class="row">

		<?php 
		foreach ($wil as $key => $value) {
			// code...
		?>
			<div class="col-md-4 col-sm-6 col-xs-12">
	            <div class="x_panel">
	              <div class="x_title">
	                <h2>Wil. <?=$value->wilayah;?></h2>
	                <div class="clearfix"></div>
	              </div>
	              <div class="x_content">
	                <div id="echart_pie<?=$value->wilayah;?>" style="height:350px;"><i class="fa fa-circle-o-notch fa-spin fa-4x" style="margin-left:40%;"></i></div>
	              </div>
	            </div>
	      	</div>
      	<?php
		}
		?>
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

		var peserta_pemilihan=[]
		//max_peserta_pemilihan=0
		//min_peserta_pemilihan=0
		var suaraDikunci=[]
		var suaraBelumDikunci=[]
		var wil=[1,2,3,4,5,6,7]
		dataMap={}
		$.post('<?=base_url();?>ajax/statistik_ppj_wil', dataMap, function(data){
			json=$.parseJSON(data)
			
			for(var i in json.num_pesertaPemilihan)
    			peserta_pemilihan.push(json.num_pesertaPemilihan[i]);

    		for(var j in json.num_suaraDikunci)
    			suaraDikunci.push(json.num_suaraDikunci[j]);

    		for(var k in json.num_BelumDikunci)
    			suaraBelumDikunci.push(json.num_BelumDikunci[k]);

			echart1();

			$.each(wil, function( index, value ) {
				iarray=value-1;
				pieChart('echart_pie'+value, peserta_pemilihan[iarray], suaraDikunci[iarray], suaraBelumDikunci[iarray], 'Wil. '+value)
			})

			pieChart('echart_pie_global', json.num_pesertaPemilihan_global, json.num_suaraDikunci_global, json.num_BelumDikunci_global, 'Perolehan Suara Total')


		})


		function echart1(){
			if ($('#mainb').length ){
			  	var echartBar = echarts.init(document.getElementById('mainb'), theme);
			  	console.log(peserta_pemilihan)
			  	echartBar.setOption({
					title: {
					 // text: 'Graph title',
					  //subtext: 'Graph Sub-text'
					},
					tooltip: {
					  trigger: 'axis'
					},
					legend: {
					  data: ['Total Peserta', 'Suara Sah', 'Suara Tidak Sah']
					},
					toolbox: {
					  show: false
					},
					calculable: false,
					xAxis: [{
					  type: 'category',
					  data: ['Wil 1', 'Wil 2', 'Wil 3', 'Wil 4', 'Wil 5', 'Wil 6', 'Wil 7']
					}],
					yAxis: [{
					  type: 'value'
					}],
					series: [{
					  name: 'Total Peserta',
					  type: 'bar',
					  data: peserta_pemilihan,
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
					}, {
					  name: 'Suara Sah',
					  type: 'bar',
					  data: suaraDikunci,
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
					},
					{
					  name: 'Suara Tidak Sah',
					  type: 'bar',
					  data: suaraBelumDikunci,
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
					}]
			  	});
			}
		}


		function pieChart(dom, peserta=0, suaradikunci=0, suarabelumdikunci=0, namePie){
			console.log(dom);
			var theme1 = {
		  	color: [
				  '#ba4d4d', '#34495E', '#BDC3C7', '#3498DB',
				  '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
		  	]}

			if ($('#'+dom).length ){  
				belummemlih=parseInt(peserta) - (parseInt(suaradikunci)+parseInt(suarabelumdikunci))
			  var echartPie = echarts.init(document.getElementById(dom), theme1);
			  echartPie.setOption({
				tooltip: {
				  trigger: 'item',
				  formatter: "{a} <br/>{b} : {c} ({d}%)"
				},
				legend: {
				  x: 'center',
				  y: 'bottom',
				  data: ['GolPut', 'Suara Sah', 'Suara Tidak Sah']
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
				  radius: '55%',
				  center: ['50%', '48%'],
				  data: [{
					value: suarabelumdikunci,
					name: 'Suara Tidak Sah'
				  }, {
					value: suaradikunci,
					name: 'Suara Sah'
				  }, {
					value: belummemlih,
					name: 'GolPut'
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
</script>
