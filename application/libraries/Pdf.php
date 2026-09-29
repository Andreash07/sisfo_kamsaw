<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf
{
    private $loaded = false;

    private function load()
    {
        if (!$this->loaded) {
            require_once FCPATH . 'pdf7/vendor/autoload.php';
            $this->loaded = true;
        }
    }

    public function create($orientation = 'P', $format = 'A4', $lang = 'en')
    {
        $this->load();

        return new \Spipu\Html2Pdf\Html2Pdf(
            $orientation,
            $format,
            $lang
        );
    }

    public function exceptionMessage($e)
    {
        $this->load();

        $formatter = new \Spipu\Html2Pdf\Exception\ExceptionFormatter($e);

        return $formatter->getHtmlMessage();
    }
}