<?php
/**
* Thrive Calendar
*   Copyright © 2011 
*       Theodore R. Smith <theodore@phpexperts.pro>
*   -and-
*       Monica Chase <chase.mono@gmail.com>
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

// Monica, I have turned your side-by-side comments into above-line comments.
// As you can see, this greatly aids cross-dev communication, addendums, and
// the ability to read on smaller screens.
// 
// PROTIP: You should also consider post-fixing your comments with your 
// name and timestamp. It greatly helps future onlookers.
//
// You should always be pro enough to stand by any code you wrote.  I leave 
// my email in the code and fix any horrible code someone finds for free, 
// even years later.  Of course, I've never been notified of my code being
// horrible, but there's a first for everything ;p 
//
// This is *particularly* important whenever you fix bugs. You generally
// should leave a note on what was wrong that you fixed. I dont do this 
// much on my own code cuz 1) it's usually not buggy and 2) I work alone.
// At work, I leave the comments religiously. -Ted 2011-03-21
abstract class ThriveCalendarLogic
{
    /** @var ThriveDate **/
    protected $date;

    // M: Where is the ThriveDate class?
    // T: At this point? Only in my head.
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
    /** @var ThriveCalendarLogic **/
    private $calendarLogic;

    // M: ThriveYear, ThriveMonth, and ThriveDay look like classes
    // T: Correct.
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
        // 'U' is the format char for epoch. -Monica 2011-03-21
        // Monica, that's a very appropriate comment!
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
