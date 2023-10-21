<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Charts | Porto Admin - Responsive HTML5 Template 1.4.1</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/vendor/morris/morris.css" />
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/vendor/chartist/chartist.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?=base_url();?>vendors/mychart/assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/modernizr/modernizr.js"></script>
	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<h2 style="margin: 0 20px; padding: 0 10px"><i class="fa fa-home" aria-label="Toggle sidebar"></i> Home</h2>
						<!--<img src="<?=base_url();?>vendors/mychart/assets/images/logo.png" height="35" alt="Porto Admin" /> -->
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
						
			
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			
				<!-- end: sidebar -->

				<section role="main" class="content-body" style="margin-left: 0 !important" >
					<header class="page-header" style="display:none;">
						<h2>Charts</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>UI Elements</span></li>
								<li><span>Charts</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
						<h2 class="mt-none">Flot Charts</h2>
						<p class="mb-lg">Flot is a pure JavaScript plotting library for jQuery, with a focus on simple usage, attractive looks and interactive features.</p>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Basic Chart</h2>
										<p class="panel-subtitle">You don't have to do much to get an attractive plot. Create a placeholder, make sure it has dimensions (so Flot knows at what size to draw the plot), then call the plot function with your data.</p>
									</header>
									<div class="panel-body">
						
										<!-- Flot: Basic -->
										<div class="chart chart-md" id="flotBasic"></div>
										<script type="text/javascript">
						
											var flotBasicData = [{
												data: [
													[0, 170],
													[1, 169],
													[2, 173],
													[3, 188],
													[4, 147],
													[5, 113],
													[6, 128],
													[7, 169],
													[8, 173],
													[9, 128],
													[10, 128]
												],
												label: "Series 1",
												color: "#0088cc"
											}, {
												data: [
													[0, 115],
													[1, 124],
													[2, 114],
													[3, 121],
													[4, 115],
													[5, 83],
													[6, 102],
													[7, 148],
													[8, 147],
													[9, 103],
													[10, 113]
												],
												label: "Series 2",
												color: "#2baab1"
											}, {
												data: [
													[0, 70],
													[1, 69],
													[2, 73],
													[3, 88],
													[4, 47],
													[5, 13],
													[6, 28],
													[7, 69],
													[8, 73],
													[9, 28],
													[10, 28]
												],
												label: "Series 3",
												color: "#734ba9"
											}];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Real-Time Chart</h2>
										<p class="panel-subtitle">You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</p>
									</header>
									<div class="panel-body">
						
										<!-- Flot: Curves -->
										<div class="chart chart-md" id="flotRealTime"></div>
						
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bars Chart</h2>
										<p class="panel-subtitle">With the categories plugin you can plot categories/textual data easily.</p>
									</header>
									<div class="panel-body">
						
										<!-- Flot: Bars -->
										<div class="chart chart-md" id="flotBars"></div>
										<script type="text/javascript">
						
											var flotBarsData = [
												["Jan", 28],
												["Feb", 42],
												["Mar", 25],
												["Apr", 23],
												["May", 37],
												["Jun", 33],
												["Jul", 18],
												["Aug", 14],
												["Sep", 18],
												["Oct", 15],
												["Nov", 4],
												["Dec", 7]
											];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Pie Chart</h2>
										<p class="panel-subtitle">Default Pie Chart</p>
									</header>
									<div class="panel-body">
						
										<!-- Flot: Pie -->
										<div class="chart chart-md" id="flotPie"></div>
										<script type="text/javascript">
						
											var flotPieData = [{
												label: "Series 1",
												data: [
													[1, 60]
												],
												color: '#0088cc'
											}, {
												label: "Series 2",
												data: [
													[1, 10]
												],
												color: '#2baab1'
											}, {
												label: "Series 3",
												data: [
													[1, 15]
												],
												color: '#734ba9'
											}, {
												label: "Series 4",
												data: [
													[1, 15]
												],
												color: '#E36159'
											}];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
						</div>
						
						<h2>Morris Charts</h2>
						<p class="mb-lg">Good-looking charts shouldn't be difficult.</p>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart</h2>
										<p class="panel-subtitle">A style of chart that is created by connecting a series of data points together with a line.</p>
									</header>
									<div class="panel-body">
						
										<!-- Morris: Line -->
										<div class="chart chart-md" id="morrisLine"></div>
										<script type="text/javascript">
						
											var morrisLineData = [{
												y: '2006',
												a: 100,
												b: 90
											}, {
												y: '2007',
												a: 75,
												b: 65
											}, {
												y: '2008',
												a: 50,
												b: 40
											}, {
												y: '2009',
												a: 75,
												b: 65
											}, {
												y: '2010',
												a: 50,
												b: 40
											}, {
												y: '2011',
												a: 75,
												b: 65
											}, {
												y: '2012',
												a: 100,
												b: 90
											}, {
												y: '2013',
												a: 75,
												b: 65
											}, {
												y: '2014',
												a: 100,
												b: 90
											}];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Donut Chart</h2>
										<p class="panel-subtitle">Donut Chart are functionally identical to pie charts.</p>
									</header>
									<div class="panel-body">
						
										<!-- Morris: Donut -->
										<div class="chart chart-md" id="morrisDonut"></div>
										<script type="text/javascript">
						
											var morrisDonutData = [{
												label: "Porto Template",
												value: 32
											}, {
												label: "Tucson Template",
												value: 18
											}, {
												label: "Porto Admin",
												value: 20
											}];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart</h2>
										<p class="panel-subtitle">A bar chart is a way of summarizing a set of categorical data.</p>
									</header>
									<div class="panel-body">
						
										<!-- Morris: Bar -->
										<div class="chart chart-md" id="morrisBar"></div>
										<script type="text/javascript">
						
											var morrisBarData = [{
												y: '2004',
												a: 10,
												b: 30
											}, {
												y: '2005',
												a: 100,
												b: 25
											}, {
												y: '2006',
												a: 60,
												b: 25
											}, {
												y: '2007',
												a: 75,
												b: 35
											}, {
												y: '2008',
												a: 90,
												b: 20
											}, {
												y: '2009',
												a: 75,
												b: 15
											}, {
												y: '2010',
												a: 50,
												b: 10
											}, {
												y: '2011',
												a: 75,
												b: 25
											}, {
												y: '2012',
												a: 30,
												b: 10
											}, {
												y: '2013',
												a: 75,
												b: 5
											}, {
												y: '2014',
												a: 60,
												b: 8
											}];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Stacked Chart</h2>
										<p class="panel-subtitle">Stacked Bar Chart.</p>
									</header>
									<div class="panel-body">
						
										<!-- Morris: Area -->
										<div class="chart chart-md" id="morrisStacked"></div>
										<script type="text/javascript">
						
											var morrisStackedData = [{
												y: '2004',
												a: 10,
												b: 30
											}, {
												y: '2005',
												a: 100,
												b: 25
											}, {
												y: '2006',
												a: 60,
												b: 25
											}, {
												y: '2007',
												a: 75,
												b: 35
											}, {
												y: '2008',
												a: 90,
												b: 20
											}, {
												y: '2009',
												a: 75,
												b: 15
											}, {
												y: '2010',
												a: 50,
												b: 10
											}, {
												y: '2011',
												a: 75,
												b: 25
											}, {
												y: '2012',
												a: 30,
												b: 10
											}, {
												y: '2013',
												a: 75,
												b: 5
											}, {
												y: '2014',
												a: 60,
												b: 8
											}];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Area Chart</h2>
										<p class="panel-subtitle">An area chart or area graph displays graphically quantitive data.</p>
									</header>
									<div class="panel-body">
						
										<!-- Morris: Area -->
										<div class="chart chart-md" id="morrisArea"></div>
										<script type="text/javascript">
						
											var morrisAreaData = [{
												y: '2004',
												a: 10,
												b: 30
											}, {
												y: '2005',
												a: 100,
												b: 25
											}, {
												y: '2006',
												a: 60,
												b: 25
											}, {
												y: '2007',
												a: 75,
												b: 35
											}, {
												y: '2008',
												a: 90,
												b: 20
											}, {
												y: '2009',
												a: 75,
												b: 15
											}, {
												y: '2010',
												a: 50,
												b: 10
											}, {
												y: '2011',
												a: 75,
												b: 25
											}, {
												y: '2012',
												a: 30,
												b: 10
											}, {
												y: '2013',
												a: 75,
												b: 5
											}, {
												y: '2014',
												a: 60,
												b: 8
											}];
						
											// See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for more settings.
						
										</script>
						
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-6">
								<h2>Circular Charts</h2>
								<p class="mb-lg">Easy pie chart is a jQuery plugin that uses the canvas element to render simple pie charts for single values.</p>
						
								<div class="row">
									<div class="col-md-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions">
													<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
													<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
												</div>
						
												<h2 class="panel-title">Easy Pie Chart</h2>
												<p class="panel-subtitle">Lightweight jQuery plugin to render and animate nice pie charts with the HTML5 canvas element.</p>
											</header>
											<div class="panel-body">
												<div class="row text-center">
													<div class="col-md-6">
														<div class="circular-bar">
															<div class="circular-bar-chart" data-percent="85" data-plugin-options='{ "barColor": "#0088CC", "delay": 300 }'>
																<strong>Design</strong>
																<label><span class="percent">85</span>%</label>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="circular-bar">
															<div class="circular-bar-chart" data-percent="60" data-plugin-options='{ "barColor": "#2BAAB1", "delay": 600 }'>
																<strong>HTML</strong>
																<label><span class="percent">60</span>%</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<h2>Gauge Charts</h2>
								<p class="mb-lg">Animated Gauge Charts</p>
						
								<div class="row">
									<div class="col-md-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions">
													<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
													<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
												</div>
						
												<h2 class="panel-title">Gauge</h2>
												<p class="panel-subtitle">100% native and cool looking animated JavaScript/CoffeScript gauge.</p>
											</header>
											<div class="panel-body">
												<div class="row text-center">
													<div class="col-md-6">
														<div class="gauge-chart">
															<canvas id="gaugeBasic" width="180" height="110" data-plugin-options='{ "value": 2150, "maxValue": 3000 }'></canvas>
															<strong>Design</strong>
															<label id="gaugeBasicTextfield"></label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="gauge-chart">
															<canvas id="gaugeAlternative" width="180" height="110" data-plugin-options='{ "value": 1350, "maxValue": 3000 }'></canvas>
															<strong>HTML</strong>
															<label id="gaugeAlternativeTextfield"></label>
														</div>
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<h2>Liquid Charts</h2>
								<p class="mb-lg">Adds animated liquid charts.</p>
						
								<div class="row">
									<div class="col-md-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions">
													<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
													<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
												</div>
						
												<h2 class="panel-title">Liquid Meter</h2>
												<p class="panel-subtitle">Exclusive Plug-in by Okler Themes</p>
											</header>
											<div class="panel-body">
												<div class="row">
													<div class="col-md-6">
														<meter min="0" max="100" value="35" id="meter"></meter>
													</div>
													<div class="col-md-6">
														<meter min="0" max="100" value="85" id="meterDark"></meter>
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<h2>Small Inline Charts</h2>
								<p class="mb-lg">Adds tiny charts called sparklines.</p>
						
								<div class="row">
									<div class="col-md-12">
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions">
													<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
													<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
												</div>
						
												<h2 class="panel-title">Sparklines</h2>
												<p class="panel-subtitle">This jQuery plugin generates sparklines (small inline charts).</p>
											</header>
											<div class="panel-body">
												<div class="row">
													<div class="col-xs-6 col-lg-4">
														<div class="small-chart-wrapper">
															<div class="small-chart" id="sparklineLine"></div>
															<div class="small-chart-info">
																<label>Average</label>
																<strong>1567.89</strong>
															</div>
															<script type="text/javascript">
																var sparklineLineData = [15, 16, 17, 19, 10, 15, 13, 12, 12, 14, 16, 17];
															</script>
														</div>
													</div>
						
													<div class="col-xs-6 col-lg-4">
														<div class="small-chart-wrapper">
															<div class="small-chart" id="sparklineBar"></div>
															<div class="small-chart-info">
																<label>Average</label>
																<strong>5000</strong>
															</div>
															<script type="text/javascript">
																var sparklineBarData = [5, 6, 7, 2, 0, 4 , 2, 4, 2, 0, 4 , 2, 4, 2, 0, 4];
															</script>
														</div>
													</div>
						
													<div class="col-xs-6 col-lg-4">
														<div class="small-chart-wrapper">
															<div class="small-chart" id="sparklineTristate"></div>
															<div class="small-chart-info">
																<label>Average</label>
																<strong>1567.89</strong>
															</div>
															<script type="text/javascript">
																var sparklineTristateData = [1, 1, 0, 1, -1, -1, 1, -1, 0, 0, 1, 1];
															</script>
														</div>
													</div>
						
													<div class="col-xs-6 col-lg-4">
														<div class="small-chart-wrapper">
															<div class="small-chart" id="sparklineDiscrete"></div>
															<div class="small-chart-info">
																<label>Average</label>
																<strong>1567.89</strong>
															</div>
															<script type="text/javascript">
																var sparklineDiscreteData = [5, 6, 7, 9, 10, 5, 3, 2, 2, 4, 6, 7];
															</script>
														</div>
													</div>
						
													<div class="col-xs-6 col-lg-4">
														<div class="small-chart-wrapper">
															<div class="small-chart" id="sparklineBullet"></div>
															<div class="small-chart-info">
																<label>Average</label>
																<strong>1567.89</strong>
															</div>
															<script type="text/javascript">
																var sparklineBulletData = [10, 12, 12, 9, 7];
															</script>
														</div>
													</div>
						
													<div class="col-xs-6 col-lg-4">
														<div class="small-chart-wrapper">
															<div class="small-chart text-center" id="sparklinePie"></div>
															<div class="small-chart-info">
																<label>Average</label>
																<strong>1567.89</strong>
															</div>
															<script type="text/javascript">
																var sparklinePieData = [1, 1, 2];
															</script>
														</div>
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
						</div>
						
						<h2>Chartist - Simple Responsive Charts</h2>
						<p class="mb-lg">You may think that this is just yet an other charting library. But Chartist.js is the product of a community that was disappointed about the abilities provided by other charting libraries. Of course there are hundreds of other great charting libraries but after using them there were always tweaks you would have wished for that were not included.</p>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart: Simple Chart</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistSimpleLineChart" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart: Scatter Diagram With Responsive Settings</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistLineScatterDiagramWithResponsiveSettings" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart: With Tooltips</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistLineChartWithTooltips" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart: With Area</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistLineChartWithArea" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart: Bi-Polar Chart With Area Only</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistBiPolarLineChartWithAreaOnly" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart: Using Events to Replace Graphics</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistEventsToReplaceGraphics" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Line Chart: Interpolation / Smoothing</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistLineInterpolationSmoothing" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart: Bi-Polar Chart</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistBiPolarBarChart" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart: Overlapping On Mobile</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistOverlappingBarsOnMobile" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart: Add Peak Circles Using Draw Events</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistAddPeakCirclesUsingDrawEvents" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart: Multi-Line Labels</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistMultiLineLabels" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart: Stacked Chart</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistStackedChart" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart: Horizontal Chart</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistHorizontalChart" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Bar Chart: Extreme Responsive Configuration</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistExtremeResponsiveConfiguration" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Pie Chart: Simple Chart</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistSimplePieChart" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Pie Chart: With Custom Labels</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistPieChartWithCustomLabels" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Gauge Chart</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistGaugeChart" class="ct-chart ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
							<div class="col-md-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">CSS Animation</h2>
									</header>
									<div class="panel-body">
										<div id="ChartistCSSAnimation" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
						
										<!-- See: <?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js for the example code. -->
									</div>
								</section>
							</div>
						</div>
					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
								<ul>
									<li>
										<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="<?=base_url();?>vendors/mychart/assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="<?=base_url();?>vendors/mychart/assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="<?=base_url();?>vendors/mychart/assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="<?=base_url();?>vendors/mychart/assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
			
						</div>
					</div>
				</div>
			</aside>
		</section>

		<!-- Vendor -->
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/jquery/jquery.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/flot/jquery.flot.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/raphael/raphael.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/morris/morris.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/gauge/gauge.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="<?=base_url();?>vendors/mychart/assets/vendor/chartist/chartist.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?=base_url();?>vendors/mychart/assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?=base_url();?>vendors/mychart/assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?=base_url();?>vendors/mychart/assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<style>
			#ChartistCSSAnimation .ct-series.ct-series-a .ct-line {
				fill: none;
				stroke-width: 4px;
				stroke-dasharray: 5px;
				-webkit-animation: dashoffset 1s linear infinite;
				-moz-animation: dashoffset 1s linear infinite;
				animation: dashoffset 1s linear infinite;
			}

			#ChartistCSSAnimation .ct-series.ct-series-b .ct-point {
				-webkit-animation: bouncing-stroke 0.5s ease infinite;
				-moz-animation: bouncing-stroke 0.5s ease infinite;
				animation: bouncing-stroke 0.5s ease infinite;
			}

			#ChartistCSSAnimation .ct-series.ct-series-b .ct-line {
				fill: none;
				stroke-width: 3px;
			}

			#ChartistCSSAnimation .ct-series.ct-series-c .ct-point {
				-webkit-animation: exploding-stroke 1s ease-out infinite;
				-moz-animation: exploding-stroke 1s ease-out infinite;
				animation: exploding-stroke 1s ease-out infinite;
			}

			#ChartistCSSAnimation .ct-series.ct-series-c .ct-line {
				fill: none;
				stroke-width: 2px;
				stroke-dasharray: 40px 3px;
			}

			@-webkit-keyframes dashoffset {
				0% {
					stroke-dashoffset: 0px;
				}

				100% {
					stroke-dashoffset: -20px;
				};
			}

			@-moz-keyframes dashoffset {
				0% {
					stroke-dashoffset: 0px;
				}

				100% {
					stroke-dashoffset: -20px;
				};
			}

			@keyframes dashoffset {
				0% {
					stroke-dashoffset: 0px;
				}

				100% {
					stroke-dashoffset: -20px;
				};
			}

			@-webkit-keyframes bouncing-stroke {
				0% {
					stroke-width: 5px;
				}

				50% {
					stroke-width: 10px;
				}

				100% {
					stroke-width: 5px;
				};
			}

			@-moz-keyframes bouncing-stroke {
				0% {
					stroke-width: 5px;
				}

				50% {
					stroke-width: 10px;
				}

				100% {
					stroke-width: 5px;
				};
			}

			@keyframes bouncing-stroke {
				0% {
					stroke-width: 5px;
				}

				50% {
					stroke-width: 10px;
				}

				100% {
					stroke-width: 5px;
				};
			}

			@-webkit-keyframes exploding-stroke {
				0% {
					stroke-width: 2px;
					opacity: 1;
				}

				100% {
					stroke-width: 20px;
					opacity: 0;
				};
			}

			@-moz-keyframes exploding-stroke {
				0% {
					stroke-width: 2px;
					opacity: 1;
				}

				100% {
					stroke-width: 20px;
					opacity: 0;
				};
			}

			@keyframes exploding-stroke {
				0% {
					stroke-width: 2px;
					opacity: 1;
				}

				100% {
					stroke-width: 20px;
					opacity: 0;
				};
			}
		</style>
		<script src="<?=base_url();?>vendors/mychart/assets/javascripts/ui-elements/examples.charts.js"></script>
	</body>
</html>