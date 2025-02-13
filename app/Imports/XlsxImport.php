<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class XlsxImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        // Default
        $importCount = count($rows);

        $barcodes = array();
        for ($i = 1; $i < $importCount; $i++) {
            // Input values
            $barcodes[$i] = [
                "name" => $rows[$i][0],
                "type" => $rows[$i][1],
                "format" => $rows[$i][2],
                "value" => $rows[$i][3],
                "width" => $rows[$i][4],
                "height" => $rows[$i][5],
                "showText" => $rows[$i][6]
            ];
        }
        
        return $barcodes;
    }
}
