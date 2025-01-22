<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-5">Cards Game</h1>
        <div class="card">
            <div class="card-body">
                <!-- form for entering the number of players. -->
                <form id="cardForm" class="row g-3">
                    <div class="col-md-12">
                        <label for="people_num" class="form-label">Enter the number of people:</label>
                        <input type="number" id="people_num" name="people_num" class="form-control" placeholder="Enter a number.">
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Distribute Cards</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Div to display the result or error messages after form submission. -->
        <div id="result" class="mt-4"></div>
    </div>
    <script>
        $(document).ready(function () {
            // handling form submission event
            $('#cardForm').on('submit', function (event) {
                event.preventDefault();

                // Validate the input: check if it's not empty and greater than 0
                if (!$('#people_num').val() || $('#people_num').val() <= 0) {
                    $('#result').html('<div class="alert alert-danger">Input value does not exist or value is invalid</div>');
                    return;  // Exit the function early
                }
                
                // Make an AJAX POST request to distribute the cards
                $.ajax({
                    url: 'controller/rounds/create.php',
                    method: 'POST',
                    data: { people_num: $('#people_num').val()  },
                    success: function (response) {
                        $('#result').html(`<div class="alert alert-success">Cards Distributed Successfully:</div><pre>${response}</pre>`);
                    },
                    error: function () {
                        $('#result').html('<div class="alert alert-danger">An error occurred while processing your request.</div>');
                    }
                });
            });
        });
    </script>
</body>