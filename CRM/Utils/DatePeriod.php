<?php

/**
 * Recurring date utilities based on PHP DatePeriod class
 */
class CRM_Utils_DatePeriod {

  public function occurrences($params) {
    $dates = array();
    // TODO validate params
    if (!empty($params['repeat_every'])) {
      $repeatEvery = $params['repeat_every'];
    }
    else {
      $repeatEvery = 1;
    }

    switch ($params['repeat']) {
      case 'daily':
        $interval = new DateInterval("P{$repeatEvery}D");
        // TODO
        $start = new DateTime($params['start_date']);
        if (!empty($params['end_date'])) {
          $end = new DateTime($params['end_date']);
          $end->add(new DateInterval('P1D'));
          $period = new DatePeriod($start, $interval, $end);
        }
        elseif (!empty($params['occurrences']) && $params['occurrences'] > 0) {
          // Third parameter to constructor is recurrences, not occurrences, so subtract 1.
          $period = new DatePeriod($start, $interval, $params['occurrences'] - 1);
        }
        else {
          // TODO
        }
        print_r($period);
        foreach ($period as $date) {
          $dates[] = $date;
        }
        print_r($dates);
        break;

      case 'weekly':
        $interval = new DateInterval("P{$repeatEvery}W");

        if (!empty($params['day_of_week'])) {
          if (is_array($params['day_of_week'])) {
            $daysOfWeek = $params['day_of_week'];
          }
          else {
            $daysOfWeek = array($params['day_of_week']);
          }

          // Construct a DatePeriod for each day_of_week and combine into array $dates.
          $end = NULL;
          $count = NULL;
          if (!empty($params['end_date'])) {
            $end = new DateTime($params['end_date']);
            $end->add(new DateInterval('P1D'));
          }
          elseif (!empty($params['occurrences']) && $params['occurrences'] > 0) {
            if (count($daysOfWeek) > 1) {
              $count = (int) ($params['occurrences'] / count($daysOfWeek));
            }
            else {
              $count = $params['occurrences'] - 1;
            }
          }
          else {
            // TODO
          }

          // For e.g. Mon, Wed every 2 weeks, we need to see if the first Mon & first Wed
          // on/after the given start date fall in the same week. If not, the first Mon
          // should be in the week in which the 2nd Wed falls.
          $firstWeek = NULL;
          foreach ($daysOfWeek as $day) {
            $startDates[$day] = new DateTime($day . ' ' . $params['start_date']);
            $week = $startDates[$day]->format('oW');
            if ($firstWeek === NULL || $week < $firstWeek) {
              $firstWeek = $week;
            }
          }
          foreach ($daysOfWeek as $day) {
            // Set $start to the first $day on or after $startDate.
            $start = $startDates[$day];
            if ($repeatEvery > 1 && $start->format('oW') > $firstWeek) {
              // TODO this needs to be N-1 weeks
              $start->add(new DateInterval('P' . ($repeatEvery - 1) . 'W'));
            }
            if (!is_null($end)) {
              $period = new DatePeriod($start, $interval, $end);
            }
            elseif (!is_null($count)) {
              $period = new DatePeriod($start, $interval, $count);
            }
            foreach ($period as $date) {
              $dates[] = $date;
            }
          }

          if (count($daysOfWeek) > 1) {
            sort($dates);
            if (!is_null($count)) {
              $dates = array_slice($dates, 0, $params['occurrences']);
            }
          }
        }
        break;

      case 'monthly':
        $interval = new DateInterval("P{$repeatEvery}M");
        // TODO
        break;
    }

    return $dates;
  }
}