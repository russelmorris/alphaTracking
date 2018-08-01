<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  M_calculation m_calculation
 * @property  M_icdate m_icdate
 * @property  M_prospects m_prospects
 * @property  M_create_csv m_create_csv
 */
class C_create_csv extends MY_Controller
{
    public $googlePath;
    public $alexaPath;

    public function __construct()
    {

        parent::__construct();
        $this->load->model([
            'm_icdate',
            'm_prospects',
            'm_create_csv'
        ]);

        $this->googlePath = "bottomUp/digiFootprint/googletrends/";
        $this->alexaPath = "bottomUp/digiFootprint/alexa/";
    }

    public function createGoogletrends()
    {
        $icDates = $this->m_icdate->getIcDates();
        $latestIcDates = find_latest_date($icDates);

        if (!is_dir($this->googlePath . $latestIcDates)) {
            mkdir($this->googlePath . $latestIcDates, 0777, TRUE);
        }

        $prospects = $this->m_prospects->getProspectsByDate($latestIcDates);

        foreach ($prospects as $prospect){

            $googleCsvData = $this->m_create_csv->getProspectKeywordCompare($prospect["RIC"]);

            $csvName = "{$latestIcDates}-{$prospect['ticker']}-{$prospect['country']}-googletrends.csv";
            $csvName = strtolower(str_replace(" ","",$csvName));

            $fp = fopen($this->googlePath . $latestIcDates. '/'. $csvName, 'w');
            fputcsv($fp,['keyword','RICType']);
            foreach ($googleCsvData as $line) {
                fputcsv($fp, $line);
            }
           // echo "<p><a href='{$this->googlePath}{$latestIcDates}/{$csvName}' target='_blank'>{$prospect["RIC"]}</a></p>";
            fclose($fp);
        }

        echo 'Googletrends CSV files are created';
    }


    public function createAlexa()
    {
        $icDates = $this->m_icdate->getIcDates();
        $latestIcDates = find_latest_date($icDates);

        if (!is_dir($this->alexaPath . $latestIcDates)) {
            mkdir($this->alexaPath . $latestIcDates, 0777, TRUE);
        }

        $prospects = $this->m_prospects->getProspectsByDate($latestIcDates);

        foreach ($prospects as $prospect){

            $googleCsvData = $this->m_create_csv->getProspectDomainCompare($prospect["RIC"]);

            $csvName = "{$latestIcDates}-{$prospect['ticker']}-{$prospect['country']}-alexa.csv";
            $csvName = strtolower(str_replace(" ","",$csvName));

            $fp = fopen($this->alexaPath . $latestIcDates. '/'. $csvName, 'w');
            fputcsv($fp,['domain','RICType']);
            foreach ($googleCsvData as $line) {
                fputcsv($fp, $line);
            }

            //echo "<p><a href='{$this->alexaPath}{$latestIcDates}/{$csvName}' target='_blank'>{$prospect["RIC"]}</a></p>";
            fclose($fp);

        }

        echo 'Alexa CSV files are created';
    }


}
