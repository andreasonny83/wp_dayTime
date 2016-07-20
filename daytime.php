<?php
$body_class = '';

function themename_customize_register($wp_customize) {
  $wp_customize->add_section(
      'daytime_section',
      array(
        'title' => 'DayTime',
        'priority' => 35,
      )
    );

  $wp_customize->add_setting(
    'monday_hour',
    array(
      'default' => '09:00 12:00 - 16:30 19:00',
    )
  );

  $wp_customize->add_control(
    'monday_hour',
    array(
        'label' => 'Monday',
        'section' => 'daytime_section',
        'type' => 'text',
    )
  );

  $wp_customize->add_setting(
    'tuesday_hour',
    array(
      'default' => '09:00 12:00 - 16:30 19:00',
    )
  );

  $wp_customize->add_control(
    'tuesday_hour',
    array(
        'label' => 'Tuesday',
        'section' => 'daytime_section',
        'type' => 'text',
    )
  );

  $wp_customize->add_setting(
    'wednesday_hour',
    array(
      'default' => '09:00 12:00 - 16:30 19:00',
    )
  );

  $wp_customize->add_control(
    'wednesday_hour',
    array(
        'label' => 'Wednesday',
        'section' => 'daytime_section',
        'type' => 'text',
    )
  );

  $wp_customize->add_setting(
    'thursday_hour',
    array(
      'default' => '09:00 12:00 - 16:30 19:00',
    )
  );

  $wp_customize->add_control(
    'thursday_hour',
    array(
        'label' => 'Thursday',
        'section' => 'daytime_section',
        'type' => 'text',
    )
  );

  $wp_customize->add_setting(
    'friday_hour',
    array(
      'default' => '09:00 12:00 - 16:30 19:00',
    )
  );

  $wp_customize->add_control(
    'friday_hour',
    array(
        'label' => 'Friday',
        'section' => 'daytime_section',
        'type' => 'text',
    )
  );

  $wp_customize->add_setting(
    'saturday_hour',
    array(
      'default' => '09:00 12:00 - 16:30 19:00',
    )
  );

  $wp_customize->add_control(
    'saturday_hour',
    array(
        'label' => 'Saturday',
        'section' => 'daytime_section',
        'type' => 'text',
    )
  );

  $wp_customize->add_setting(
    'sunday_hour',
    array(
      'default' => '09:00 12:00 - 16:30 19:00',
    )
  );

  $wp_customize->add_control(
    'sunday_hour',
    array(
        'label' => 'Sunday',
        'section' => 'daytime_section',
        'type' => 'text',
    )
  );
}

function daytime_func() {
  date_default_timezone_set('Europe/London');
  $sTime = date('Y-m-d');
  $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
  $re = "/(\\d{2}):(\\d{2}) (\\d{2}):(\\d{2})\\s-\\s(\\d{2}):(\\d{2}) (\\d{2}):(\\d{2})/";
  $openingHours = array();

  foreach ($days as $key => $day) {
    preg_match($re, get_theme_mod( $day . '_hour', '' ), $match);
    if (sizeof($match) === 9) {
      $openingHours[$day] = array($match[1], $match[2], $match[3], $match[4],
                                  $match[5], $match[6], $match[7], $match[8]);
    } else {
      $openingHours[$day] = [0, 0, 0, 0, 0, 0, 0, 0];
    }
  }

  $dayofweek = date('w', strtotime($sTime)) - 1;
  $today = $days[$dayofweek];
  $now = date('G') . date('i');

  if (
      ($now > (sprintf('%02d', $openingHours[$today][0]) . sprintf('%02d', $openingHours[$today][1])) &&
      $now <= (sprintf('%02d', $openingHours[$today][2]) . sprintf('%02d', $openingHours[$today][3]))) ||
      ($now > (sprintf('%02d', $openingHours[$today][4]) . sprintf('%02d', $openingHours[$today][5])) &&
      $now <= (sprintf('%02d', $openingHours[$today][6]) . sprintf('%02d', $openingHours[$today][7])))
  ) {
    return true;
  } else {
    return false;
  }

  return false;
}

function daytime_shortcode( $atts, $content = null ) {
  // If wprocket is present, clean the cache first
  require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
	
	if ( function_exists( 'rocket_clean_domain' ) ) {
	rocket_clean_domain();
 }
 
  $a = shortcode_atts( array(
          'when' => 'open'
      ), $atts );

  $open = daytime_func();

  if ($a['when'] === 'open' && $open === true) {
    return $content;
  } else if ($a['when'] === 'close' && $open === false) {
    return $content;
  }

  return false;
}

add_shortcode( 'daytime', 'daytime_shortcode' );
add_action( 'customize_register', 'themename_customize_register' );
add_filter( 'body_class', function( $classes = '' ) {
    if (daytime_func() === true) {
      return array_merge( $classes, array( 'wpDayTime--open' ) );
    } else {
      return array_merge( $classes, array( 'wpDayTime--close' ) );
    }
} );
