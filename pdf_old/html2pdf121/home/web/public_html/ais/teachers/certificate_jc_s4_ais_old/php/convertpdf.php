    <?php
        ob_start();
        include('test.php');
       
        $content = ob_get_clean();
        require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
        try
        {
            $html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(30, 0, 20, 0));
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('test.pdf');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    ?>
