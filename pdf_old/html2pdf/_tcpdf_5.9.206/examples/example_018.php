<?php
//============================================================+
// File name   : example_018.php
// Begin       : 2008-03-06
// Last Update : 2011-10-01
//
// Description : Example 018 for TCPDF class
//               RTL document with Persian language
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: RTL document with Persian language
 * @author Nicola Asuni
 * @since 2008-03-06
 */

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

 
// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

//set some language-dependent strings
$pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
$pdf->SetFont('cid0kr', '', 9);

// add a page
$pdf->AddPage();

// Persian and English content
$htmlpersian = '<span color="#660000">

<p>&nbsp;</p>

<table style="font-size:14px; text-align:center; width:600px">
	<tbody>
		<tr>
			<td rowspan="1" style="text-align:center"><img alt="bbslog" src="bbsrc.jpg" style="height:151px; width:180px" /></td>
			<td style="width:400px">
			<p><strong>华文部</strong> <span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:16px"><strong>DEPARTMENT OF CHINESE LANGUAGE</strong></span></span></p>

			<p>期中考 <span style="font-family:Arial,Helvetica,sans-serif">SEMESTRAL ASSESSMENT 1</span></p>

			<p>学年度&nbsp;<span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:12px">ACADEMIC YEAR [-ay-]</span></span></p>
			</td>
		</tr>
	</tbody>
</table>

<table cellspacing="10">
	<tbody>
		<tr>
			<td style="width:145px"><span style="font-family:Arial,Helvetica,sans-serif">NAME </span>(姓名): &nbsp;&nbsp;</td>
			<td>
			<div style="border:1px solid black; height:30px; width:460px">&nbsp;</div>
			</td>
		</tr>
	</tbody>
</table>

<table cellspacing="10">
	<tbody>
		<tr>
			<td style="width:145px"><span style="font-family:Arial,Helvetica,sans-serif">CLASS</span> (班级): <span style="font-family:Arial,Helvetica,sans-serif">Primary</span></td>
			<td>
			<div style="border:1px solid black; height:30px; width:460px">&nbsp;</div>
			</td>
		</tr>
	</tbody>
</table>

<hr />
<table style="height:239px; width:319px">
	<tbody>
		<tr>
			<td colspan="2" style="width:500px">华文程度<strong> <span style="font-family:Arial,Helvetica,sans-serif">CHINESE LANGUAGE Level 3</span></strong></td>
		</tr>
		<tr>
			<td colspan="2" style="width:500px">作文卷<strong> <span style="font-family:Arial,Helvetica,sans-serif">Paper 1 Composition Writing</span></strong></td>
		</tr>
		<tr>
			<td colspan="2" style="width:500px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:250px"><span style="font-family:Arial,Helvetica,sans-serif">Total Questions</span>（总题数）</td>
			<td style="width:250px">: <span style="font-family:Arial,Helvetica,sans-serif">10 Questions</span> 题</td>
		</tr>
		<tr>
			<td colspan="2" style="width:500px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:250px"><span style="font-family:Arial,Helvetica,sans-serif">Total Marks</span>（总分）</td>
			<td style="width:250px">: <span style="font-family:Arial,Helvetica,sans-serif">100 Marks</span>&nbsp;分</td>
		</tr>
		<tr>
			<td colspan="2" style="width:500px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:250px"><span style="font-family:Arial,Helvetica,sans-serif">Date</span>(日期 )</td>
			<td style="width:250px">:[-day, [-date-]</td>
		</tr>
		<tr>
			<td colspan="2" style="width:500px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:250px"><span style="font-family:Arial,Helvetica,sans-serif">Duration</span>（作答时间）</td>
			<td style="width:250px">: <span style="font-family:Arial,Helvetica,sans-serif">[-duration-]</span> 分钟</td>
		</tr>
	</tbody>
</table>

<div style="height:20px">&nbsp;</div>

<hr />
<div style="height:20px">&nbsp;</div>

<div style="width:650px; word-wrap:break-word"><span style="font-family:Arial,Helvetica,sans-serif"><strong>READ THESE INSTRUCTIONS FIRST</strong></span></div>

<div style="height:20px">&nbsp;</div>

<div style="width:650px; word-wrap:break-word">请不要擅自翻开考卷。<span style="font-family:Arial,Helvetica,sans-serif">Do <strong>not</strong> turn this page until you are told to do so.</span></div>

<div style="height:20px">&nbsp;</div>

<div style="width:650px; word-wrap:break-word">请仔细遵照提示作答。<span style="font-family:Arial,Helvetica,sans-serif">Follow all instructions carefully.</span></div>

<div style="height:20px">&nbsp;</div>

<div style="width:650px; word-wrap:break-word">请做完所有的考题。<span style="font-family:Arial,Helvetica,sans-serif">Answer <strong>all</strong> questions.</span></div>

<div style="height:20px">&nbsp;</div>

<div style="height:20px">&nbsp;</div>

<div style="height:20px">&nbsp;</div>
 

<table style="font-size:12px; height:125px; width:1000px">
	<tbody>
		<tr>
			<td style="vertical-align:bottom; width:400px">家长签名 <span style="font-family:Arial,Helvetica,sans-serif">(Parent&#39;s Signature)</span> __________________________</td>
			<td style="text-align:right; vertical-align:bottom; width:600px">
			<table border="1" cellspacing="0" style="border-collapse:collapse; border:1px solid black; height:100px; width:600px">
				<tbody>
					<tr>
						<td colspan="2" style="height:10px; text-align:center; width:220px"><strong><span style="font-family:Arial,Helvetica,sans-serif">TOTAL SCORE</span><br />
						&nbsp;&nbsp;&nbsp;&nbsp; </strong>总&nbsp;&nbsp;&nbsp; 分<strong>&nbsp;&nbsp;&nbsp;</strong></td>
					</tr>
					<tr>
						<td style="height:35px; text-align:center; width:40px">&nbsp;</td>
						<td style="height:35px; text-align:center; vertical-align:middle; width:40px"><span style="font-size:14px"><strong>100</strong> </span></td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>

<hr />
<p style="text-align:center">这份考卷包含封面一共有 _ 页。<span style="font-family:Arial,Helvetica,sans-serif">This document consists of&nbsp; printed pages.</span></p>




';

$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
 

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_018.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
