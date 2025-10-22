<?php
$json = file_get_contents('database/json/users.json');
$data = json_decode($json, true);

if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
    echo "JSON is valid!\n";
    echo "Total users: " . count($data) . "\n";
    
    // Count users with placeholder created_at
    $placeholderCount = 0;
    foreach ($data as $user) {
        if (isset($user['created_at']) && strpos($user['created_at'], '2025-10-22') === 0) {
            $placeholderCount++;
        }
    }
    
    echo "Users with placeholder created_at (2025-10-22): " . $placeholderCount . "\n";
    
    // Show some sample real dates
    echo "\nSample registration dates:\n";
    for ($i = 0; $i < min(5, count($data)); $i++) {
        echo "- " . $data[$i]['name'] . ": " . $data[$i]['created_at'] . "\n";
    }
} else {
    echo "JSON Error: " . json_last_error_msg() . "\n";
}
