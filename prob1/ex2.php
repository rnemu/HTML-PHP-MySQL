<!DOCTYPE html>
<html>

<head>
    <title>Example PHP MySQL Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #0056b3;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid rgb(0, 0, 255);
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #0056b3;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d1e7ff;
        }

        td {
            font-size: 14px;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Movie and Actor Search Results</h2>

    <?php
    // Find the partial name of the actor from the form
    if (isset($_POST['MovieName']) && !empty(trim($_POST['MovieName']))) {
        $partialName = $_POST['MovieName'];
        echo "<p class='success'>Partial name of Movie is: <strong>" . htmlspecialchars($partialName) . "</strong></p>";
    } else {
        echo "<p class='error'>Name of Movie is not defined</p>";
        exit(1); // Stop execution if no input provided
    }

    // Open a connection to the database
    $dbconn = mysqli_connect('localhost', 'rnemu', 'Rakesh@123', 'movies');

    if (!$dbconn) {
        echo "<p class='error'>Database connection could not be established</p>";
        exit(1);
    } else {
        echo "<p class='success'>Database connection is successful</p>";
    }

    // Create the query statement
    $querystmt = "SELECT * FROM starsin WHERE title LIKE '%" . mysqli_real_escape_string($dbconn, $partialName) . "%' ORDER BY title";
    echo "<p>Created query is: <code>" . htmlspecialchars($querystmt) . "</code></p>";

    // Execute the query
    $qresult = mysqli_query($dbconn, $querystmt);

    if (!$qresult) {
        echo "<p class='error'>Query could not be executed by MySQL</p>";
        exit(1);
    }

    // Print number of rows
    $nrows = mysqli_num_rows($qresult);
    echo "<p>Number of rows in the answer: <strong>" . $nrows . "</strong></p>";

    if ($nrows > 0) {
        // Display results in a table
        echo "<table>";
        echo "<tr><th>Movie Title</th><th>Actor Name</th><th>Role</th></tr>";

        while ($row = mysqli_fetch_assoc($qresult)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['starname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>No results found</p>";
    }

    // Close the database connection
    mysqli_close($dbconn);
    ?>

</body>

</html>

