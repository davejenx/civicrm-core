<?php
require_once 'CiviTest/CiviUnitTestCase.php';
class CRM_Utils_DatePeriodTest extends CiviUnitTestCase {
  /* This test case doesn't require DB reset */
  public $DBResetRequired = FALSE;

  /*
   * Daily tests.
   */
  function testDailyEveryDayEndDate() {
    // Every day 25 June - 5 July 2014, specifying end date.
    $params = array(
      'start_date' => '2014-06-25 09:30',
      'end_date' => '2014-07-05',
      'repeat' => 'daily',
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-25 09:30', '2014-06-26 09:30', '2014-06-27 09:30', '2014-06-28 09:30', '2014-06-29 09:30', '2014-06-30 09:30', '2014-07-01 09:30', '2014-07-02 09:30', '2014-07-03 09:30', '2014-07-04 09:30', '2014-07-05 09:30');
    self::_compareDates($expected, $dates, 'Y-m-d H:i');
  }

  function testDailyEveryDayOccurrences() {
    // Every day 25 June - 5 July 2014, specifying number of occurrences.
    $params = array(
      'start_date' => '2014-06-25',
      'occurrences' => 10,
      'repeat' => 'daily',
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-25', '2014-06-26', '2014-06-27', '2014-06-28', '2014-06-29', '2014-06-30', '2014-07-01', '2014-07-02', '2014-07-03', '2014-07-04');
    self::_compareDates($expected, $dates);
  }

  function testDailyEveryThreeDaysEndDate() {
    // Every three days 20 June - 10 July 2014, specifying end date.
    $params = array(
      'start_date' => '2014-06-20',
      'end_date' => '2014-07-10',
      'repeat' => 'daily',
      'repeat_every' => 3,
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-20', '2014-06-23', '2014-06-26', '2014-06-29', '2014-07-02', '2014-07-05', '2014-07-08');
    self::_compareDates($expected, $dates);
  }

  function testDailyEveryThreeDaysOccurrences() {
    // Every three days 20 June - 10 July 2014, specifying number of occurrences.
    $params = array(
      'start_date' => '2014-06-20',
      'occurrences' => 10,
      'repeat' => 'daily',
      'repeat_every' => 3,
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-20', '2014-06-23', '2014-06-26', '2014-06-29', '2014-07-02', '2014-07-05', '2014-07-08', '2014-07-11', '2014-07-14', '2014-07-17');
    self::_compareDates($expected, $dates);
  }

  /*
   * Weekly tests.
   */
  function testWeeklySingleDayEndDate() {
    // All Mondays in June 2014, specifying end date.
    $params = array(
      'start_date' => '2014-06-01',
      'end_date' => '2014-06-30',
      'repeat' => 'weekly',
      'day_of_week' => 'Mon',
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-02', '2014-06-09', '2014-06-16', '2014-06-23', '2014-06-30');
    self::_compareDates($expected, $dates);
  }

  function testWeeklySingleDayOccurrences() {
    // All Mondays in June 2014, specifying number of occurrences.
    $params = array(
      'start_date' => '2014-06-01',
      'occurrences' => 5,
      'repeat' => 'weekly',
      'day_of_week' => 'Mon',
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-02', '2014-06-09', '2014-06-16', '2014-06-23', '2014-06-30');
    self::_compareDates($expected, $dates);
  }

  function testTwoWeeklySingleDayEndDate() {
    // Every two weeks on Monday 1 June - 31 July 2014, specifying end date.
    $params = array(
      'start_date' => '2014-06-01',
      'end_date' => '2014-07-31',
      'repeat' => 'weekly',
      'repeat_every' => 2,
      'day_of_week' => 'Mon',
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-02', '2014-06-16', '2014-06-30', '2014-07-14', '2014-07-28');
    self::_compareDates($expected, $dates);
  }

  function testTwoWeeklySingleDayOccurrences() {
    // Every two weeks on Monday 1 June - 31 July 2014, specifying number of occurrences.
    $params = array(
      'start_date' => '2014-06-01',
      'occurrences' => 5,
      'repeat' => 'weekly',
      'repeat_every' => 2,
      'day_of_week' => 'Mon',
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-02', '2014-06-16', '2014-06-30', '2014-07-14', '2014-07-28');
    self::_compareDates($expected, $dates);
  }

  function testWeeklyMultiDayEndDate() {
    // All Mondays, Wednesdays & Fridays in June 2014, specifying end date.
    $params = array(
      'start_date' => '2014-06-01',
      'end_date' => '2014-06-30',
      'repeat' => 'weekly',
      'day_of_week' => array('Mon', 'Wed' , 'Fri'),
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-02', '2014-06-04', '2014-06-06', '2014-06-09', '2014-06-11', '2014-06-13', '2014-06-16', '2014-06-18', '2014-06-20', '2014-06-23', '2014-06-25', '2014-06-27', '2014-06-30');
    self::_compareDates($expected, $dates);
  }

  function testWeeklyMultiDayOccurrences() {
    // First 10 Mondays, Wednesdays & Fridays in June 2014, specifying number of occurrences.
    $params = array(
      'start_date' => '2014-06-01',
      'occurrences' => 10,
      'repeat' => 'weekly',
      'day_of_week' => array('Mon', 'Wed' , 'Fri'),
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-02', '2014-06-04', '2014-06-06', '2014-06-09', '2014-06-11', '2014-06-13', '2014-06-16', '2014-06-18', '2014-06-20', '2014-06-23');
    self::_compareDates($expected, $dates);
  }

  function testTwoWeeklyMultiDayEndDate() {
    // Mondays, Wednesdays & Fridays every two weeks in 3 June - 31 July 2014, starting Weds, specifying end date.
    $params = array(
      'start_date' => '2014-06-03',
      'end_date' => '2014-07-31',
      'repeat' => 'weekly',
      'repeat_every' => 2,
      'day_of_week' => array('Mon', 'Wed' , 'Fri'),
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-04', '2014-06-06', '2014-06-16', '2014-06-18', '2014-06-20', '2014-06-30', '2014-07-02', '2014-07-04', '2014-07-14', '2014-07-16', '2014-07-18', '2014-07-28', '2014-07-30');
    self::_compareDates($expected, $dates);

    // As above but with days specified in different order - expect same result.
    $params = array(
      'start_date' => '2014-06-03',
      'end_date' => '2014-07-31',
      'repeat' => 'weekly',
      'repeat_every' => 2,
      'day_of_week' => array('Fri', 'Wed', 'Mon'),
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    self::_compareDates($expected, $dates);
  }

  function testTwoWeeklyMultiDayOccurrences() {
    // Mondays, Wednesdays & Fridays every two weeks in 3 June - 31 July 2014, starting Weds, specifying number of occurrences.
    $params = array(
      'start_date' => '2014-06-03',
      'occurrences' => 13,
      'repeat' => 'weekly',
      'repeat_every' => 2,
      'day_of_week' => array('Mon', 'Wed' , 'Fri'),
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-04', '2014-06-06', '2014-06-16', '2014-06-18', '2014-06-20', '2014-06-30', '2014-07-02', '2014-07-04', '2014-07-14', '2014-07-16', '2014-07-18', '2014-07-28', '2014-07-30');
    self::_compareDates($expected, $dates);
  }

  function testThreeWeeklyMultiDayEndDate() {
    // Mondays, Wednesdays & Fridays every three weeks in 3 June - 31 Aug 2014, starting Fri, specifying end date.
    $params = array(
      'start_date' => '2014-06-05',
      'end_date' => '2014-08-31',
      'repeat' => 'weekly',
      'repeat_every' => 3,
      'day_of_week' => array('Mon', 'Wed' , 'Fri'),
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-06', '2014-06-23', '2014-06-25', '2014-06-27', '2014-07-14', '2014-07-16', '2014-07-18', '2014-08-04', '2014-08-06', '2014-08-08', '2014-08-25', '2014-08-27', '2014-08-29');
    self::_compareDates($expected, $dates);
  }

  function testThreeWeeklyMultiDayOccurrences() {
    // Mondays, Wednesdays & Fridays every three weeks in 3 June - 31 Aug 2014, starting Fri, specifying end date.
    $params = array(
      'start_date' => '2014-06-05',
      'occurrences' => 13,
      'repeat' => 'weekly',
      'repeat_every' => 3,
      'day_of_week' => array('Mon', 'Wed' , 'Fri'),
    );
    $dates = CRM_Utils_DatePeriod::occurrences($params);
    $expected = array('2014-06-06', '2014-06-23', '2014-06-25', '2014-06-27', '2014-07-14', '2014-07-16', '2014-07-18', '2014-08-04', '2014-08-06', '2014-08-08', '2014-08-25', '2014-08-27', '2014-08-29');
    self::_compareDates($expected, $dates);
  }

  /*
   * Monthly tests.
   */

  /*
   * Helper functions.
   */
  private function _compareDates($expected, $dates, $format = 'Y-m-d') {
    $this->assertEquals(count($expected), count($dates));
    foreach ($dates as $index => $date) {
      $this->assertEquals($expected[$index], $date->format($format));
    }
  }
}
