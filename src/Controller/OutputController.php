<?php

namespace App\Controller;

class OutputController{

    /**
     * Generate a csv file from a data array.
     * @param array $data
     */
    public function writeCSVFile($data = []): void
    {
        //Open a file for write
        $file = fopen('payDates.csv', 'w');
        $headers = ['Period', 'Basic Payment', 'Bonus Payment'];
        fputcsv($file, $headers);

        foreach ($data as $record){
            fputcsv($file, $record);
        }
    }
}