<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NiceLog | Log File Analyzer</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: gray;
            color: white;
        }

        /* Set a fixed width for the Requested URL column */
        .requested-url {
            max-width: 300px; /* Adjust the value as needed */
            /* overflow: hidden; */
            /* text-overflow: ellipsis; */
            /* white-space: nowrap; */
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div style="background: gray; border-radius: 20px;">
        <h1 style="margin-left: 15px; font-size:30px; color: white;">NiceLog <i style="margin-left: 300px;font-size: 25px">Log Analyzer Tool by RK.Sahu</i></h1>
    </div>

    <form action="" method="post" style="text-align: center;" enctype="multipart/form-data">
        <label for="logFile">Choose a log file:</label>
        <input type="file" name="logFile" accept="">
        <button type="submit" name="submit">Analyze</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        if (isset($_FILES['logFile']) && $_FILES['logFile']['error'] == 0) {
            $uploadedFile = $_FILES['logFile']['tmp_name'];

            // Read the file line by line
            $lines = file($uploadedFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Array to store log data
            $logData = [];

            $totlog = 0;

            foreach ($lines as $line) {
                $totlog = $totlog + 1;

                // Regular expression to match the log entry
                $pattern = '/^([\d\.]+) - - \[([^\]]+)\] "([^"]+)" (\d+) (\d+) "([^"]*)" "([^"]*)"$/';
                preg_match($pattern, $line, $matches);

                if (count($matches) === 8) {
                    list(, $ip, $timestamp, $request, $responseCode, $protocol, $referrer, $userAgent) = $matches;

                    // Subtract 90 minutes from the timestamp
                    $timestamp = date('Y-m-d H:i:s', strtotime($timestamp) - 90 * 60);

                    // Split the request into HTTP Method, Requested URL, and Protocol
                    list($httpMethod, $requestedUrl, $protocol) = explode(' ', $request, 3);

                    // Store log data in an array
                    $logData[] = [
                        'timestamp' => strtotime($timestamp), // Convert timestamp to Unix timestamp for sorting
                        'ip' => $ip,
                        'httpMethod' => $httpMethod,
                        'requestedUrl' => $requestedUrl,
                        'protocol' => $protocol,
                        'responseCode' => $responseCode,
                        'referrer' => $referrer, // Display Referring URL in the "Referring URL" column
                        'userAgent' => $userAgent, // Display User-Agent in the "User-Agent" column
                    ];
                }
            }

            // Sort the log data by timestamp in descending order
            usort($logData, function ($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });

            ?>
            <span style="font-weight:bold;">Total Record: <?php echo $totlog; ?></span>
            <?php

            // Display the sorted log data
            echo "<table border='1'>";
            echo "<tr><th>Adjusted Timestamp</th><th>IP Address</th><th>HTTP Method</th><th class='requested-url'>Requested URL</th><th>HTTP Response Code</th><th>User-Agent</th><th>Referring URL</th><th>Protocol</th></tr>";

            foreach ($logData as $logEntry) {

                $backgroundColor = '';
                $textcol = '';

                switch ($logEntry['responseCode']) {
                    case 200:
                        $backgroundColor = 'green';
                        $textcol = 'white';
                        break;
                    case 304:
                        $backgroundColor = 'gray';
                        $textcol = 'white';
                        break;
                    case 302:
                        $backgroundColor = 'red';
                        $textcol = 'white';
                        break;
                    default:
                        $backgroundColor = '';
                        break;
                }


                echo "<tr>";
                echo "<td>" . date('d/m/Y H:i:s', $logEntry['timestamp']) . "</td><td>{$logEntry['ip']}</td><td>{$logEntry['httpMethod']}</td><td class='requested-url'>{$logEntry['requestedUrl']}</td><td style='background-color: $backgroundColor;color:$textcol'>{$logEntry['responseCode']}</td><td>{$logEntry['userAgent']}</td><td>{$logEntry['referrer']}</td><td>{$logEntry['protocol']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Please choose a valid log file.</p>";
        }
    }
    ?>
</body>
</html>
