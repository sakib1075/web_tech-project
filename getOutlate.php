<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'outlet.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $outlate_query = mysqli_query($conn, "SELECT * FROM outlate");
    $id = 1;

    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>View Outlates</title>
              <style>
              body {
                  font-family: Times new roman;
                  background-color: #f4f4f4;
                  margin: 0;
                  padding: 0;
              }

              table {
                  width: 80%;
                  margin: 20px auto;
                  border-collapse: collapse;
              }

              th, td {
                  border: 1px solid #ddd;
                  padding: 8px;
                  text-align: left;
              }

              th {
                  background-color: #072227;
                  color: white;
              }

              tr {
                background-color: #aefeff;
                }

              tr:nth-child(even) {
                  background-color: #778899;
              }

              tr:hover {
                  background-color: #f1f1f1;
              }

              .empty-text {
                  text-align: center;
                  padding: 20px;
                  font-weight: bold;
              }
          </style>
          </head>
          <body>";

    if ($outlate_query) {
        if (mysqli_num_rows($outlate_query) > 0) {
            echo "<table>
                  <thead>
                      <th>ID</th>
                      <th>City</th>
                      <th>Address</th>
                      <th>Contact</th>
                  </thead>
                  <tbody>";

            while ($outlate = mysqli_fetch_assoc($outlate_query)) {
                echo "<tr>
                        <td>{$id}</td>
                        <td>{$outlate['city']}</td>
                        <td>{$outlate['address']}</td>
                        <td>{$outlate['contact']}</td>
                      </tr>";
                $id++;
            }

            echo "</tbody>
                  </table>";
        } else {
            echo "<div class='empty-text'> No Outlates Available </div>";
        }
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }

    echo "</body></html>";
} else {
    echo "Invalid request.";
}
?>
