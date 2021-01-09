<?php
class Calendar {
    
    public static function get_calendar() {
        parse_str($_SERVER['QUERY_STRING'], $args);
        
        if (!isset($args['mo'])){
            $dateComponents = getdate();
            $month = $dateComponents['mon'];
            $year = $dateComponents['year'];
        } else {
            $month = $args['mo'];
            $year = $args['yr'];
        }
        
        $output = '';
        $output .= self::build_previousMonth($month, $year, $monthString);
        $output .= self::build_nextMonth($month,$year,$monthString);
        $output .= self::build_calendar($month,$year,$dateArray);
        
        return $output;
    }
    
    static function build_calendar($month,$year,$dateArray) {
        
        // Create array containing abbreviations of days of week.
        $daysOfWeek = array(
            __('Mon'),
            __('Tues'),
            __('Wed'),
            __('Thurs'),
            __('Fri'),
            __('Sat'),
            __('Sun')
        );
        
        // What is the first day of the month in question?
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
        
        // How many days does this month contain?
        $numberDays = date('t',$firstDayOfMonth);
        
        // Retrieve some information about the first day of the
        // month in question.
        $dateComponents = getdate($firstDayOfMonth);
        
        // What is the name of the month in question?
        $monthName = ucfirst(__($dateComponents['month']));
        
        // What is the index value (0-6) of the first day of the
        // month in question.
        $dayOfWeek = $dateComponents['wday'];
        
        // Create the table tag opener and day headers
        
        $calendar = "<div style='width: 100%; display:inline; padding: 20px;'>";
        $calendar .= "<table class='calendar'>";
        $calendar .= "<caption>$monthName $year</caption>";
        $calendar .= "<tr>";
        
        // Create the calendar headers
        
        foreach($daysOfWeek as $day) {
            $calendar .= "<th class='header'>$day</th>";
        }
        
        // Create the rest of the calendar
        
        // Initiate the day counter, starting with the 1st.
        
        $currentDay = 1;
        
        $calendar .= "</tr><tr>";
        
        // The variable $dayOfWeek is used to
        // ensure that the calendar
        // display consists of exactly 7 columns.
        $dayOfWeek --;
        if ($dayOfWeek > 0) {
            $calendar .= "<td colspan='$dayOfWeek' class='not-month'>&nbsp;</td>";
        }
        
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
        
        while ($currentDay <= $numberDays) {
            
            $content = self::get_day_content($currentDay, $month, $year);
            
            // Seventh column (Sunday) reached. Start a new row.
            
            if ($dayOfWeek == 7) {
                
                $dayOfWeek = 0;
                $calendar .= "</tr><tr>";
                
            }
            
            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";
            
            if ($date == date("Y-m-d")){
                $calendar .= "<td class='day today' rel='$date'><span class='today-date'>$currentDay<br>$content</span></td>";
            }
            else{
                $calendar .= "<td class='day' rel='$date'><span class='day-date'>$currentDay<br>$content</span></td>";
            }
            
            
            // Increment counters
            $currentDay++;
            $dayOfWeek++;
            
        }
        
        
        
        // Complete the row of the last week in month, if necessary
        
        if ($dayOfWeek != 7) {
            
            $remainingDays = 7 - $dayOfWeek;
            $calendar .= "<td colspan='$remainingDays' class='not-month'>&nbsp;</td>";
            
        }
        
        $calendar .= "</tr>";
        
        $calendar .= "</table>";
        $calendar .= '</div>';
        
        return $calendar;
        
    }
    
    static function build_previousMonth($month,$year,$monthString){
        
        $prevMonth = $month - 1;
        
        if ($prevMonth == 0) {
            $prevMonth = 12;
        }
        
        if ($prevMonth == 12){
            $prevYear = $year - 1;
        } else {
            $prevYear = $year;
        }
        
        $dateObj = DateTime::createFromFormat('!m', $prevMonth);
        $monthName = ucfirst(__($dateObj->format('F')));
        
        return "<div style='width: 33%; display:inline-block;'><a href='?mo=" . $prevMonth . "&yr=". $prevYear ."'><- " . $monthName . "</a></div>";
    }
    
    static function build_nextMonth($month,$year,$monthString){
        
        $nextMonth = $month + 1;
        
        if ($nextMonth == 13) {
            $nextMonth = 1;
        }
        
        if ($nextMonth == 1){
            $nextYear = $year + 1;
        } else {
            $nextYear = $year;
        }
        
        $dateObj = DateTime::createFromFormat('!m', $nextMonth);
        $monthName = ucfirst(__($dateObj->format('F')));
        
        return "<div style='width: 33%; display:inline-block;'>&nbsp;</div><div style='width: 33%; display:inline-block; text-align:right;'><a href='?mo=" . $nextMonth . "&yr=". $nextYear ."'>" . $monthName . " -></a></div>";
    }
    
    static function get_day_content( $currentDay, $month, $year ) {
        $loads = Tasks_Resources::getLoadsByDay($currentDay, $month, $year);
        $output = '';
        if ( $loads && (sizeof($loads) > 0) ) {
            
            foreach ( $loads as $load ) {
                $output .= '<p class="load-status-' . intval($load['value']/10) . '">' . $load['username'] . ' (' . $load['value'] . '%)</p>';
            }
        }
        return $output;
    }
     
}
