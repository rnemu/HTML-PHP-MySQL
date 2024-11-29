<!DOCTYPE html>
<html>
<head>
    <title>Movie Review Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #444;
        }

        form {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: none;
        }

        legend {
            font-size: 1.2em;
            font-weight: bold;
            color: #555;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select, input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        textarea {
            resize: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 1em;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .no-movies {
            color: #d9534f;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h2>Add a Review for a Movie</h2>
    <form method="POST" action="submit_review.php">
        <fieldset>
            <legend>Movie Review</legend>
            
            <!-- Dropdown list for movie titles -->
            <label for="title">Select Movie Title:</label>
            <select name="title" id="title">
                <?php
                    // Database connection
                    $dbconn = mysqli_connect('localhost', 'rnemu', 'Rakesh@123', 'movies');
                    
                    // Check connection
                    if (!$dbconn) {
                        die("<option class='no-movies'>Connection failed: " . mysqli_connect_error() . "</option>");
                    }

                    // Fetch movie titles from the 'movies' table
                    $query = "SELECT title FROM movies ORDER BY title";
                    $result = mysqli_query($dbconn, $query);

                    // Check if the query was successful
                    if (!$result) {
                        die("<option class='no-movies'>Query failed: " . mysqli_error($dbconn) . "</option>");
                    }

                    // Generate the dropdown options
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=\"" . htmlspecialchars($row['title']) . "\">" . htmlspecialchars($row['title']) . "</option>";
                        }
                    } else {
                        echo "<option class='no-movies' value=\"\">No movies available</option>";
                    }

                    // Close the database connection
                    mysqli_close($dbconn);
                ?>
            </select>
            
            <!-- Textbox for user ID -->
            <label for="user">User ID:</label>
            <input type="text" name="user" id="user" size="25" required>
            
            <!-- Textarea for the review -->
            <label for="review">Write your review:</label>
            <textarea name="review" id="review" rows="12" cols="80" maxlength="1000"></textarea>
            
            <!-- Submit button -->
            <input type="submit" value="Submit Review">
        </fieldset>
    </form>
</body>
</html>

