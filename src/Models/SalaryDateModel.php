<?php

namespace App\Models;

class SalaryDateModel
{

    /**
     * @var - datetime current month we are working with
     */
    private $currentDateTime;

    /**
     * Generate 12 months of salary payment details
     * @return array
     */
    public function generateData(): array
    {
        //Iterate 12 times to output an array of data
        $output = [];

        //Iterate over next 12 months
        for ($monthIndex=1;$monthIndex<13;$monthIndex++){
            $output[] = $this->getDates($monthIndex);
        }
        return $output;
    }

    /**
     * Create the internal datetime object and return an entry for 1 month
     * @param $index
     * @return array
     */
    private function getDates($index): array
    {
        //Create a DateTime Object for the current month plus the offset;
        $this->setCurrentDateTimeObject(new \DateTime("+ {$index} month"));
        return ['month' => $this->currentDateTime->format('M/y'), 'bonusDay' => $this->getBonusDay(), 'payDay' =>$this->getPayDay()];
    }

    /**
     * Return the bonus day, this should be the 10th of the month
     * or the next working day
     * Uses the current date time object
     * @return string
     */
    private function getBonusDay(): string
    {
        //Modify the date time to the 10th
        $this->setCurrentDateTimeObject($this->getCurrentDateTimeObject()->setDate($this->getCurrentDateTimeObject()->format('Y'), $this->getCurrentDateTimeObject()->format('m'), 10));
        while (!$this->isWorkDay($this->getCurrentDateTimeObject()->format('l'))){
            $this->setCurrentDateTimeObject($this->getCurrentDateTimeObject()->modify('+1 day'));
        }
        return $this->getCurrentDateTimeObject()->format('Y-m-d');
    }

    /**
     * Payday is last working day of calendar month.
     * Try last day and work backwards
     * @return string
     */
    private function getPayDay()
    {
        $this->setCurrentDateTimeObject($this->getCurrentDateTimeObject()->modify('last day of this month'));
        while(!$this->isWorkDay($this->getCurrentDateTimeObject()->format('l'))) {
            $this->setCurrentDateTimeObject($this->getCurrentDateTimeObject()->modify('-1 day'));
        }
        return $this->getCurrentDateTimeObject()->format('Y-m-d');
    }

    /**
     * Logic check used to determine a working day.
     * @param $day
     * @return bool
     */
    private function isWorkDay($day): bool
    {
        $returnValue = false;
        $workingDays =['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        if (isset($day) && !empty($day) && in_array(strtolower($day), $workingDays)){
            $returnValue = true;
        }
        return $returnValue;
    }

    /**
     * Return the current date time object or failsafe with a new datetime object
     * @return DateTime Object
     */
    public function getCurrentDateTimeObject(): \DateTime
    {
        return $this->currentDateTime instanceof \DateTime ? $this->currentDateTime : new \DateTime();
    }

    /**
     * Setter
     * @param mixed $currentDateTime
     */
    public function setCurrentDateTimeObject($currentDateTime): void
    {
        $this->currentDateTime = $currentDateTime;
    }
}