<?php
// Thrive Calendar
// This file is a part of the Thrive Framework, a PHPExperts.pro Project.
//
// Copyright (c) 2012 Theodore R.Smith (theodore@phpexperts.pro)
// DSA-1024 Fingerprint: 10A0 6372 9092 85A2 BB7F  907B CB8B 654B E33B F1ED
// Provided by the PHP University (www.phpu.cc) and PHPExperts.pro (www.phpexperts.pro)
//
// This file is dually licensed under the terms of the following licenses:
// * Primary License: OSSAL v1.0 - Open Source Software Alliance License
//   * Key points:
//       5.Redistributions of source code in any non-textual form (i.e.
//          binary or object form, etc.) must not be linked to software that is
//          released with a license that requires disclosure of source code
//          (ex: the GPL).
//       6.Redistributions of source code must be licensed under more than one
//          license and must not have the terms of the OSSAL removed.
//   * See LICENSE.ossal for complete details.
//
// * Secondary License: Creative Commons Attribution License v3.0
//   * Key Points:
//       * You are free:
//           * to copy, distribute, display, and perform the work
//           * to make non-commercial or commercial use of the work in its original form
//       * Under the following conditions:
//           * Attribution. You must give the original author credit. You must retain all
//             Copyright notices and you must include the sentence, "Based upon work from
//             PHPExperts.pro (www.phpexperts.pro).", wherever you list contributors.
//   * See LICENSE.cc_by for complete details.

abstract class Thrive_CalendarLogic
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
    public function getNumberOfDaysInMonth();
}

// M: Is there supposed to be an 'f' here?
// T: Yes, it is derived from my associate's Flourish library's fDate class.
class ThriveDate extends fDate
{
    /** @var Thrive_CalendarLogic **/
    private $calendarLogic;

    /** @var ThriveYear **/         
    private $year;
    
    /** @var ThriveMonth **/
    private $month;
    
    /** @var ThriveDay **/
    private $day;

    public function __construct($calendarLogic = null)
    {
        $this->year = new ThriveYear();
        $this->month = new ThriveMonth();
        $this->day =  new ThriveDay();
                
       // $this->year  = $year;
       // $this->month = $month;
       // $this->day   = $day;

        // Assume calendarLogic defaults to Gregorian:
        if ($calendarLogic === null)
        {
            $calendarLogic = new Thrive_Calendar_GregorianLogic;
        }

        $this->date = strtotime("$year-$month-$day");
        $this->date = $calendarLogic->
        $this->calendarLogic = $calendarLogic;
    }
}

class Thrive_Calendar
{
    /** @var Thrive_CalendarLogice **/
    private $lineLogic;

    public function __construct(Thrive_CalendarLogic $calendarLogic, $dateString)
    {
        $calendarLogic-
        $this->year = $year;
    }

    
}

class Thrive_Calendar_GregorianLogic extends Thrive_CalendarLogic
{
    public function getEpochTime()
    {
        // 'U' is the format char for epoch. -Monica 2011-03-21
        return date('U');
    }

    public function __construct(ThriveMonth $month)
    {
        $numberOfDays = $this->numberOfDaysInMonth($month);
        {
            for ($d = 1; $d <= $numberOfDays; ++$d)
            {
                $this->days[$d] = new Day;
            }
        }
    }
}

class LunarCalendarLogic
{
    
}
