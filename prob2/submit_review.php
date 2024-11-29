<!DOCTYPE html>
<html>
<head>
    <title>Submit Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .success {
            color: #28a745;
        }

        .error {
            color: #dc3545;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-size: 1em;
            margin-top: 20px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Database connection details
        $dbconn = mysqli_connect("localhost", "rnemu", "Rakesh@123", "movies");

        // Check connection
        if (!$dbconn) {
            echo "<div class='message error'>Connection failed: " . mysqli_connect_error() . "</div>";
            exit;
        }

        // Retrieve form data and sanitize input
        $title = mysqli_real_escape_string($dbconn, $_POST['title']);
        $user = mysqli_real_escape_string($dbconn, $_POST['user']);
        $review = mysqli_real_escape_string($dbconn, $_POST['review']);

        // Check if any field is empty
        if (empty($title) || empty($user) || empty($review)) {
            echo "<div class='message error'>All fields are required.</div>";
            echo "<a href='prob2.php'>Go back to the review form</a>";
            exit;
        }

        // Check if the review already exists
        $checkQuery = "SELECT * FROM Reviews WHERE title='$title' AND user='$user'";
        $checkResult = mysqli_query($dbconn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "<div class='message error'>A review for this movie by the same user already exists.</div>";
            echo "<a href='prob2.php'>Go back to the review form</a>";
        } else {
            // Insert the review if it doesn't exist
            $query = "INSERT INTO Reviews (title, user, review) VALUES ('$title', '$user', '$review')";

            if (mysqli_query($dbconn, $query)) {
                echo "<div class='message success'>Review submitted successfully!</div>";
                echo "<a href='prob2.php'>Add another review</a>";
            } else {
                echo "<div class='message error'>Error: " . $query . "<br>" . mysqli_error($dbconn) . "</div>";
                echo "<a href='prob2.php'>Go back to the review form</a>";
            }
        }

        // Close database connection
        mysqli_close($dbconn);
        ?>
    </div>
</body>
</html>

