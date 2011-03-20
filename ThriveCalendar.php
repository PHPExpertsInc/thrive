<?php
/**
* Rosetta Blog
*   Copyright © 2011 Theodore R. Smith <theodore@phpexperts.pro>
*
* The following code is licensed under a modified BSD License.
* All of the terms and conditions of the BSD License apply with one
* exception:
*
* 1. Every one who has not been a registered student of the "PHPExperts
*    From Beginner To Pro" course (http://www.phpexperts.pro/) is forbidden
*    from modifing this code or using in an another project, either as a
*    deritvative work or stand-alone.
*
* BSD License: http://www.opensource.org/licenses/bsd-license.php
**/

abstract class ThriveCalendarLogic
{
    /** @var ThriveDate **/
    protected $date;

    public function __construct(ThriveDate $date)
    {
        
    }
    
    /**
    * Seconds since 1970-01-01 00:00:00 UTC.
    * @return int
    */
    public function getEpochTime();
}

class ThriveDate extends fDate
{
    /** @var ThriveCalendarLogic **/
    private $calendarLogic;

    /** @var ThriveYear **/
    private $year;
    
    /** @var ThriveMonth **/
    private $month;
    
    /** @var ThriveDay **/
    private $day;

    public function __construct(ThriveYear $year, ThriveMonth $month, ThriveDay $day, ThriveCalendarLogic $calendarLogic = null)
    {
        $this->year  = $year;
        $this->month = $month;
        $this->day   = $day;

        // Assume calendarLogic defaults to Gregorian:
        if ($calendarLogic === null)
        {
            $calendarLogic = new ThriveCalendar_GregorianLogic;
        }

        $this->date = strtotime("$year-$month-$day");
        $this->date = $calendarLogic->
        $this->calendarLogic = $calendarLogic;
    }
}

class ThriveCalendar
{
    /** @var ThriveCalendarLogice **/
    private $lineLogic;

    public function __construct(ThriveCalendarLogic $calendarLogic, $dateString)
    {
        $calendarLogic-
        $this->year = $year;
    }

    
}

class ThriveCalendar_GregorianLogic extends ThriveCalendarLogic
{
    public function getEpochTime()
    {
        return 
    }
}

class LunarCalendarLogic
{
    
}

