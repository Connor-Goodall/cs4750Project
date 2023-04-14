<!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body style = "background: #5be7a9;">
    <?php include("header.php") ?>

    <?php

    $keyword = $_GET['keyword'];
    $statement = $db->prepare("select `Department`, `Name` from `Faculty` join `User` on User.computing_id = Faculty.computing_id
                             where `Department` like '%$keyword%'");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    ?>

    <br>
    <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
        Club Finder Faculty Search
    </p>
    <br>
    <form name=facultySearch action=facultySearch.php method="GET" style="text-align: center">
        <div class = "row mb-4 mx-3">
            <input type = "text" class = "form-control" name = "keyword" style = "border: 2px solid black;" placeholder = "Search Faculty..."/>
        </div>
        <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Search Faculty"
        title = "Search" style = "width: 10%; display: block; margin: auto;"
        />
    </form>

    <div class="container mt-5" style="text-align: center">
        <?php
            if ($results) {
                foreach ($results as $row) {
                    echo '<div class="card mx-auto" style="width: 18rem; text-align: center">';
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title" style="font-size:18px">' . $row['Name'] . '</h5>';
                                echo '<p class="card-text" style="font-size:12px">' . $row['Department'] . '</p>';
                        echo '</div>';
                    echo '</div>';
                    echo '<br>';
                }
            } else {
                echo '<h3>No search results found...</h3>';
            }
        ?>
    </div>

    </body>
</html>