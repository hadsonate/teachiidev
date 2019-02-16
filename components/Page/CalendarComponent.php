<?php
require_once 'libs/View.php';
class CalendarComponent extends View
{

    public function __construct()
    {
        parent::__construct();
    }


    function build_html_calendar($year, $month, $events = null) {

        // CSS classes
        $css_cal = 'calendar';
        $css_cal_row = 'calendar-row';
        $css_cal_day_head = 'calendar-day-head';
        $css_cal_day = 'calendar-day';
        $css_cal_day_number = 'day-number';
        $css_cal_day_blank = 'calendar-day-np';
        $css_cal_day_event = 'calendar-day-event';
        $css_cal_event = 'calendar-event';

        // Table headings
        $headings = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];

        // Start: draw table
        $calendar =
            "<table cellpadding='0' cellspacing='0' class='{$css_cal}'>" .
            "<tr class='{$css_cal_row}'>" .
            "<td class='{$css_cal_day_head}'>" .
            implode("</td><td class='{$css_cal_day_head}'>", $headings) .
            "</td>" .
            "</tr>";

        // Days and weeks
        $running_day = date('N', mktime(0, 0, 0, $month, 1, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

        // Row for week one
        $calendar .= "<tr class='{$css_cal_row}'>";

        // Print "blank" days until the first of the current week
        for ($x = 1; $x < $running_day; $x++) {
            $calendar .= "<td class='{$css_cal_day_blank}'> </td>";
        }

        // Keep going with days...
        for ($day = 1; $day <= $days_in_month; $day++) {

            // Check if there is an event today
            $cur_date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            $draw_event = false;
            if (isset($events) && isset($events[$cur_date])) {
                $draw_event = true;
            }

            // Day cell
            $calendar .= $draw_event ?
                "<td class='{$css_cal_day} {$css_cal_day_event}'>" :
                "<td class='{$css_cal_day}'>";

            // Add the day number
            $calendar .= "<div class='{$css_cal_day_number}'>" . $day . "</div>";

            // Insert an event for this day
            if ($draw_event) {
                $calendar .=
                    "<div class='{$css_cal_event}'>" .
                    "<a href='{$events[$cur_date]['href']}'>" .
                    $events[$cur_date]['text'] .
                    "</a>" .
                    "</div>";
            }

            // Close day cell
            $calendar .= "</td>";

            // New row
            if ($running_day == 7) {
                $calendar .= "</tr>";
                if (($day + 1) <= $days_in_month) {
                    $calendar .= "<tr class='{$css_cal_row}'>";
                }
                $running_day = 1;
            }

            // Increment the running day
            else {
                $running_day++;
            }

        } // for $day

        // Finish the rest of the days in the week
        if ($running_day != 1) {
            for ($x = $running_day; $x <= 7; $x++) {
                $calendar .= "<td class='{$css_cal_day_blank}'> </td>";
            }
        }

        // Final row
        $calendar .= "</tr>";

        // End the table
        $calendar .= '</table>';

        // All done, return result
        return $calendar;
    }
}
