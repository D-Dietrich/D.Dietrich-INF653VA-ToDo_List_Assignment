<?php require("database.php") ?>
<?php $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List Assignment - D. Dietrich</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
    <section id="sheet">
    <header>
            <h1> To Do List:</h1>
        </header>
        <form id="myForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for='title'>Title:</label>
                <input type="text" id="title" name="title" required>
                <label for='description'>Description:</label>
                <input type="text" id="description" name="description" required>
                <button type="submit" name="submit" id="submit" class="sub_button">Add Item</button>
            </form>

            <?php if ($title && $description) {
			$query = "INSERT INTO todoitems (Title, Description) VALUES (:title, :description)";
            $statement=$db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':description', $description);
            $statement->execute();
            $statement->closeCursor();
			 }?>

               
                    <?php 
                    $query = "SELECT * FROM todoitems";
                     $statement=$db->prepare($query);
                     $statement->execute();
                     $results = $statement->fetchAll();
                     $statement->closeCursor();
                     ?>

            <?php if(!$results){?>
               <h2> There are no To Do items to display</h2> 
                    
                     <?php } else { ?>
            <table>
                <thead>
                    <tr>
                        <th>Task</th>
                        <th >Action</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <?php foreach($results as $result) {
                        $id = $result["ItemNum"];
                        $title = $result["Title"];
                        $description = $result["Description"]; ?>
                        <tr>
                            <td> <?php echo $title; ?> </td>
                            <td > <?php echo "Description: ", $description; ?> </td>
                            <td id="delete_button" > 
                                <form id="delete" action = "delete_task.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <button> X </button>
                            </td>
                        </tr>
                    <?php } }?>	
                </tbody>
            </table>

</section>
    </main>
</body>
</html>