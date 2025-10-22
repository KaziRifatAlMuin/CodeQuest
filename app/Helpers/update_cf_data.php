<?php

// Read current users.json
$json = file_get_contents('database/json/users.json');
$users = json_decode($json, true);

// CF API data mapping (handle => data)
$cfData = [
    'jiangly' => ['rating' => 3757, 'maxRating' => 4039, 'friendOfCount' => 42203],
    'tourist' => ['rating' => 3629, 'maxRating' => 4009, 'friendOfCount' => 84440],
    'Shayan' => ['rating' => 2691, 'maxRating' => 2751, 'friendOfCount' => 7733],
    'galen_colin' => ['rating' => 2641, 'maxRating' => 2657, 'friendOfCount' => 8849],
    'Soumya1' => ['rating' => 2439, 'maxRating' => 2548, 'friendOfCount' => 3658],
    'nfssdq' => ['rating' => 2435, 'maxRating' => 2461, 'friendOfCount' => 2595],
    'Alfeh' => ['rating' => 2354, 'maxRating' => 2354, 'friendOfCount' => 2393],
    'aryanc403' => ['rating' => 2287, 'maxRating' => 2452, 'friendOfCount' => 913],
    'DrSwad' => ['rating' => 2251, 'maxRating' => 2251, 'friendOfCount' => 1990],
    'serotonin' => ['rating' => 2249, 'maxRating' => 2398, 'friendOfCount' => 2256],
    'Priyansh31dec' => ['rating' => 2188, 'maxRating' => 2188, 'friendOfCount' => 15064],
    'Anachor' => ['rating' => 2142, 'maxRating' => 2609, 'friendOfCount' => 4485],
    'YouKn0wWho' => ['rating' => 2128, 'maxRating' => 2812, 'friendOfCount' => 11227],
    'Alpha_Q' => ['rating' => 2123, 'maxRating' => 2462, 'friendOfCount' => 4548],
    'CoderAbhi27' => ['rating' => 2114, 'maxRating' => 2151, 'friendOfCount' => 2963],
    'adnan_toky' => ['rating' => 2111, 'maxRating' => 2259, 'friendOfCount' => 2750],
    'Queue' => ['rating' => 2023, 'maxRating' => 2104, 'friendOfCount' => 4245],
    'arman_ferdous' => ['rating' => 2013, 'maxRating' => 2167, 'friendOfCount' => 1864],
    'ruhan.habib39' => ['rating' => 1940, 'maxRating' => 2115, 'friendOfCount' => 1905],
    'thisIsMorningstar' => ['rating' => 1937, 'maxRating' => 2183, 'friendOfCount' => 1791],
    'Prady' => ['rating' => 1935, 'maxRating' => 2127, 'friendOfCount' => 3060],
    'sadi_74' => ['rating' => 1932, 'maxRating' => 1994, 'friendOfCount' => 643],
    'Abdullah500' => ['rating' => 1912, 'maxRating' => 2036, 'friendOfCount' => 644],
    'I_Love_you_Tithi' => ['rating' => 1910, 'maxRating' => 1971, 'friendOfCount' => 655],
    'i_pranavmehta' => ['rating' => 1909, 'maxRating' => 1912, 'friendOfCount' => 1893],
    'greenbinjack' => ['rating' => 1907, 'maxRating' => 1907, 'friendOfCount' => 239],
    'Arnob' => ['rating' => 1905, 'maxRating' => 2151, 'friendOfCount' => 1255],
    'Raiden' => ['rating' => 1893, 'maxRating' => 2304, 'friendOfCount' => 2212],
    'iLoveOru' => ['rating' => 1859, 'maxRating' => 1927, 'friendOfCount' => 270],
    'daud04' => ['rating' => 1858, 'maxRating' => 1938, 'friendOfCount' => 524],
    'Zobayer_Abedin' => ['rating' => 1854, 'maxRating' => 1945, 'friendOfCount' => 522],
    'weavile' => ['rating' => 1826, 'maxRating' => 1929, 'friendOfCount' => 296],
    'Soumojitkgp' => ['rating' => 1815, 'maxRating' => 1939, 'friendOfCount' => 1027],
    'BrehamPie' => ['rating' => 1803, 'maxRating' => 1956, 'friendOfCount' => 815],
    'Ami_Nul' => ['rating' => 1789, 'maxRating' => 1941, 'friendOfCount' => 446],
    'Niloy_Das_19' => ['rating' => 1781, 'maxRating' => 1781, 'friendOfCount' => 384],
    'MinhazIbnMizan' => ['rating' => 1773, 'maxRating' => 2040, 'friendOfCount' => 660],
    'Noctambulant' => ['rating' => 1764, 'maxRating' => 1927, 'friendOfCount' => 237],
    'dipra_' => ['rating' => 1735, 'maxRating' => 1735, 'friendOfCount' => 68],
    'aka.Sohieb' => ['rating' => 1728, 'maxRating' => 2067, 'friendOfCount' => 611],
    'Sabbir1807070' => ['rating' => 1728, 'maxRating' => 1805, 'friendOfCount' => 466],
    'Wasimur' => ['rating' => 1727, 'maxRating' => 1839, 'friendOfCount' => 797],
    'TahsinArafat' => ['rating' => 1716, 'maxRating' => 1957, 'friendOfCount' => 938],
    'ioweheralot' => ['rating' => 1710, 'maxRating' => 1789, 'friendOfCount' => 186],
    'daud02' => ['rating' => 1694, 'maxRating' => 1694, 'friendOfCount' => 13],
    'MultiThread' => ['rating' => 1678, 'maxRating' => 1885, 'friendOfCount' => 422],
    'Parvej' => ['rating' => 1674, 'maxRating' => 1841, 'friendOfCount' => 426],
    'ABTurjo121' => ['rating' => 1655, 'maxRating' => 1655, 'friendOfCount' => 159],
    'NM_Mehedy' => ['rating' => 1642, 'maxRating' => 1649, 'friendOfCount' => 175],
    'JAC_Sadi' => ['rating' => 1629, 'maxRating' => 1755, 'friendOfCount' => 222],
    'Arvi_saleque' => ['rating' => 1619, 'maxRating' => 1619, 'friendOfCount' => 346],
    'iLove7' => ['rating' => 1616, 'maxRating' => 1670, 'friendOfCount' => 36],
    'being_mysterious' => ['rating' => 1596, 'maxRating' => 1705, 'friendOfCount' => 264],
    'RagePhoenix' => ['rating' => 1524, 'maxRating' => 1604, 'friendOfCount' => 195],
    'ill.soul' => ['rating' => 1448, 'maxRating' => 1448, 'friendOfCount' => 115],
    'goromPani' => ['rating' => 1444, 'maxRating' => 1444, 'friendOfCount' => 71],
    'RifatALmuiN' => ['rating' => 1421, 'maxRating' => 1489, 'friendOfCount' => 258],
    'Sazzad14802' => ['rating' => 1406, 'maxRating' => 1406, 'friendOfCount' => 96],
    'salehin_076923' => ['rating' => 1369, 'maxRating' => 1387, 'friendOfCount' => 79],
    'khansiyam216' => ['rating' => 1363, 'maxRating' => 1470, 'friendOfCount' => 37],
    'narukami00' => ['rating' => 1351, 'maxRating' => 1351, 'friendOfCount' => 31],
    'void_Farid' => ['rating' => 1246, 'maxRating' => 1382, 'friendOfCount' => 76],
    'pHySiCsBoY' => ['rating' => 1241, 'maxRating' => 1336, 'friendOfCount' => 30],
    'tahmids55' => ['rating' => 1305, 'maxRating' => 1342, 'friendOfCount' => 66],
    'The_Variant' => ['rating' => 1273, 'maxRating' => 1273, 'friendOfCount' => 44],
    'Saikat_Shahariar' => ['rating' => 1266, 'maxRating' => 1359, 'friendOfCount' => 54],
    'Okay' => ['rating' => 1254, 'maxRating' => 1526, 'friendOfCount' => 85],
    'newaz234' => ['rating' => 1202, 'maxRating' => 1252, 'friendOfCount' => 42],
    'ankonroy' => ['rating' => 1201, 'maxRating' => 1352, 'friendOfCount' => 59],
    'mayer_doa_coder' => ['rating' => 1190, 'maxRating' => 1429, 'friendOfCount' => 64],
    'Beblet' => ['rating' => 1198, 'maxRating' => 1257, 'friendOfCount' => 72],
    'Shah_Makhdum' => ['rating' => 1157, 'maxRating' => 1212, 'friendOfCount' => 51],
    'niloychowdhury' => ['rating' => 1147, 'maxRating' => 1320, 'friendOfCount' => 72],
    'nazat_08' => ['rating' => 1113, 'maxRating' => 1133, 'friendOfCount' => 46],
    'a.ruby' => ['rating' => 1116, 'maxRating' => 1216, 'friendOfCount' => 23],
    'roy.aavas' => ['rating' => 1102, 'maxRating' => 1202, 'friendOfCount' => 67],
    'rahi088' => ['rating' => 1086, 'maxRating' => 1261, 'friendOfCount' => 26],
    'tahmidalbi' => ['rating' => 1081, 'maxRating' => 1280, 'friendOfCount' => 29],
    'beg2207091' => ['rating' => 1077, 'maxRating' => 1077, 'friendOfCount' => 10],
    'shahidur8381' => ['rating' => 1074, 'maxRating' => 1163, 'friendOfCount' => 13],
    'mirzasamia' => ['rating' => 1071, 'maxRating' => 1173, 'friendOfCount' => 39],
    'Code1000101' => ['rating' => 1069, 'maxRating' => 1080, 'friendOfCount' => 30],
    'JIM_54' => ['rating' => 1024, 'maxRating' => 1140, 'friendOfCount' => 9],
    'Sourov_112' => ['rating' => 982, 'maxRating' => 982, 'friendOfCount' => 33],
    'Rocksta' => ['rating' => 972, 'maxRating' => 998, 'friendOfCount' => 37],
    'zaman_' => ['rating' => 950, 'maxRating' => 1037, 'friendOfCount' => 22],
    'SheikhGalib' => ['rating' => 904, 'maxRating' => 963, 'friendOfCount' => 27],
    'ishrat02' => ['rating' => 895, 'maxRating' => 895, 'friendOfCount' => 38],
    'Mehereen' => ['rating' => 857, 'maxRating' => 936, 'friendOfCount' => 27],
    'skt_pie' => ['rating' => 849, 'maxRating' => 849, 'friendOfCount' => 26],
    'Rajorshi_Das' => ['rating' => 753, 'maxRating' => 773, 'friendOfCount' => 28],
    'Unary_Masum' => ['rating' => 730, 'maxRating' => 803, 'friendOfCount' => 19],
    'Its_Mithu' => ['rating' => 715, 'maxRating' => 918, 'friendOfCount' => 35],
    'ksun48' => ['rating' => 3723, 'maxRating' => 3781, 'friendOfCount' => 7195],
    'Petr' => ['rating' => 3104, 'maxRating' => 3597, 'friendOfCount' => 13170],
    'rng_58' => ['rating' => 3074, 'maxRating' => 3115, 'friendOfCount' => 4798],
    'Benq' => ['rating' => 3747, 'maxRating' => 3833, 'friendOfCount' => 18035],
    'ecnerwala' => ['rating' => 3555, 'maxRating' => 3741, 'friendOfCount' => 10349],
    'tmwilliamlin168' => ['rating' => 2931, 'maxRating' => 2931, 'friendOfCount' => 11340],
    'Um_nik' => ['rating' => 3315, 'maxRating' => 3663, 'friendOfCount' => 17934],
    'maroonrk' => ['rating' => 3181, 'maxRating' => 3650, 'friendOfCount' => 5385],
    'scott_wu' => ['rating' => 3290, 'maxRating' => 3350, 'friendOfCount' => 3920],
    'neal' => ['rating' => 3055, 'maxRating' => 3147, 'friendOfCount' => 10795],
];

// Function to calculate average problem rating based on max rating
function getAverageProblemRating($maxRating) {
    if ($maxRating >= 3000) return rand(2200, 2600);
    if ($maxRating >= 2400) return rand(1900, 2300);
    if ($maxRating >= 2100) return rand(1700, 2100);
    if ($maxRating >= 1900) return rand(1500, 1900);
    if ($maxRating >= 1600) return rand(1300, 1700);
    if ($maxRating >= 1400) return rand(1100, 1500);
    if ($maxRating >= 1200) return rand(900, 1300);
    return rand(800, 1200);
}

// Function to calculate solved problems count based on rating
function getSolvedProblemsCount($maxRating) {
    if ($maxRating >= 3500) return rand(2500, 4000);
    if ($maxRating >= 3000) return rand(2000, 3500);
    if ($maxRating >= 2600) return rand(1500, 2500);
    if ($maxRating >= 2400) return rand(1200, 2000);
    if ($maxRating >= 2100) return rand(800, 1500);
    if ($maxRating >= 1900) return rand(600, 1200);
    if ($maxRating >= 1600) return rand(400, 900);
    if ($maxRating >= 1400) return rand(250, 600);
    if ($maxRating >= 1200) return rand(150, 400);
    if ($maxRating >= 1000) return rand(80, 250);
    return rand(30, 150);
}

// Update users with CF data
foreach ($users as &$user) {
    $handle = $user['cf_handle'];
    
    if (isset($cfData[$handle])) {
        $data = $cfData[$handle];
        
        // Update max rating (use current rating if max rating is 0)
        $user['cf_max_rating'] = $data['maxRating'];
        
        // Update followers count
        $user['followers_count'] = $data['friendOfCount'];
        
        // Calculate solved problems count
        $user['solved_problems_count'] = getSolvedProblemsCount($data['maxRating']);
        
        // Calculate average problem rating
        $user['average_problem_rating'] = getAverageProblemRating($data['maxRating']);
    } else {
        // For users not in CF data, give dummy values based on their existing rating
        $maxRating = $user['cf_max_rating'];
        
        if ($maxRating == 0) {
            // If rating is 0, assign a modest rating
            $maxRating = rand(1200, 1600);
            $user['cf_max_rating'] = $maxRating;
        }
        
        if ($user['followers_count'] == 0) {
            $user['followers_count'] = rand(20, 200);
        }
        
        if ($user['solved_problems_count'] == 0) {
            $user['solved_problems_count'] = getSolvedProblemsCount($maxRating);
        }
        
        if ($user['average_problem_rating'] == 0) {
            $user['average_problem_rating'] = getAverageProblemRating($maxRating);
        }
    }
}

// Save updated data
$updatedJson = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents('database/json/users.json', $updatedJson);

echo "✓ Updated users.json successfully!\n";
echo "Total users: " . count($users) . "\n\n";

// Show sample updates
echo "Sample updates:\n";
for ($i = 0; $i < min(10, count($users)); $i++) {
    $u = $users[$i];
    echo sprintf(
        "- %s: Rating=%d, Solved=%d, AvgRating=%d, Followers=%d\n",
        $u['name'],
        $u['cf_max_rating'],
        $u['solved_problems_count'],
        $u['average_problem_rating'],
        $u['followers_count']
    );
}
