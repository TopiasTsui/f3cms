<?php
namespace F3CMS;

class XlsReadFilter implements PHPExcel_Reader_IReadFilter
{
    private $_startRow = 0;

    private $_endRow = 0;

    private $_columns = array();

    public function __construct($startRow, $endRow, $columns) {
        $this->_startRow    = $startRow;
        $this->_endRow      = $endRow;
        $this->_columns     = $columns;
    }

    public function readCell($column, $row, $worksheetName = '') {
        if ($row >= $this->_startRow && $row <= $this->_endRow) {
            if (in_array($column,$this->_columns)) {
                return true;
            }
        }
        return false;
    }

    static function number2Ts($dateValue = 0, $base = 'win') {
        if ($base == 'win') { // Base date of 1st Jan 1900 = 1.0
            $myExcelBaseDate = 25569;
            //  Adjust for the spurious 29-Feb-1900 (Day 60)
            if ($dateValue < 60) {
                --$myExcelBaseDate;
            }
        } else { // Base date of 2nd Jan 1904 = 1.0
            $myExcelBaseDate = 24107;
        }

        // Perform conversion
        if ($dateValue >= 1) {
            $utcDays = $dateValue - $myExcelBaseDate;
            $returnValue = round($utcDays * 24 * 60 * 60);
            if (($returnValue <= PHP_INT_MAX) && ($returnValue >= -PHP_INT_MAX)) {
                $returnValue = (integer) $returnValue;
            }
        } else {
            $hours = round($dateValue * 24);
            $mins = round($dateValue * 24 * 60) - round($hours * 60);
            $secs = round($dateValue * 24 * 60 * 60) - round($hours * 60 * 60) - round($mins * 60);
            $returnValue = (integer) gmmktime($hours, $mins, $secs);
        }

        // Return
        return $returnValue;
    }
}
