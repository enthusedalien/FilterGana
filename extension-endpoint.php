<?php
    // Header functions to configure connections to Filtergana extension
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
    // Specifies the formatting of information returned to the extension
    header("Content-Type: application/json");

    // Guardrail during connection/verification
    if($_SERVER["REQUEST_METHOD"] === 'OPTIONS')
    {
        exit(0);
    }
    
    // stores the request information from Background.js
    $input = json_decode(file_get_contents('php://input'), true);

    // safety check to make sure extension requests are actually valid
    if (isset($input['action']) && $input['action'] === 'getinfo')
    {
        
        // code to get table data from the sql database
        $conn = mysqli_connect("localhost", "root", "", "filtergana");
        if(!$conn){
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
        }
        
        // Set encoding to UTF8 so Japanese Furigana are recognized
        mysqli_set_charset($conn, "utf8mb4");

        // obtain the furigana contents from SQL database to be sent to the extension
        $sql = "SELECT kanji, furigana FROM filtered_words";
    
        // What is obtained from the sql query
        $queryResult = mysqli_query($conn, $sql);
        
        // handling for whether the sql query was successful or not
        if ($queryResult)
        {
            $row = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);
            // $filtered_words = array_column($row, 'furigana');
            echo json_encode(['status' => 'success', 'result' => $row]);
        }
        else
        {
            echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . mysqil_error($conn)]);
        }

        // close the SQL connection
        mysqli_close($conn);
    }
    else 
    {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action; something went wrong']);
    }
?>