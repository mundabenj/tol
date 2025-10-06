 <?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ClassAutoLoad.php'; // Include the autoloader

// Set user data to insert
$user_data = ['fullname' => 'Alice Okama', 'email' => 'alice.okama@yahoo.com'];

// call the insert method
$insert_result = $SQL->insert('users', $user_data);


function time_elapsed($secs) {
    $units = array(
        'year'   => 31556926,
        'week'   => 604800,
        'day'    => 86400,
        'hour'   => 3600,
        'minute' => 60,
        'second' => 1
    );

    $ret = [];

    foreach ($units as $name => $divisor) {
        $quot = floor($secs / $divisor);
        if ($quot) {
            $ret[] = $quot . ' ' . $name . ($quot > 1 ? 's' : '');
            $secs %= $divisor;
        }
    }

    return $ret ? implode(', ', $ret) : '0 seconds';
}


echo time_elapsed(4000) . "<br>"; // Output: "1 hour, 6 minutes, 40 seconds"
echo time_elapsed(86400 * 3 + 60) . "<br>"; // Output: "3 days, 1 minute"
echo time_elapsed(31556926 + 604800 * 2) . "<br>"; // Output: "1 year, 2 weeks"


print date('Y-m-d H:i:s', strtotime('+' . time_elapsed(4000))) . "<br>";