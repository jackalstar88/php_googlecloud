<?php 

// Prepared statement (or parameterized statement) happens in 2 phases:
//   1. prepare() sends a template to the server, the server analyzes the syntax
//                and initialize the internal structure.
//   2. bind value (if applicable) and execute
//      bindValue() fills in the template (~fill in the blanks.
//                For example, bindValue(':name', $name);
//                the server will locate the missing part signified by a colon
//                (in this example, :name) in the template
//                and replaces it with the actual value from $name.
//                Thus, be sure to match the name; a mismatch is ignored.
//      execute() actually executes the SQL statement

function getAllItems() {
    global $db;
    $query = "SELECT * FROM item_list";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(); //array
    $statement->closeCursor();  
    return $results;
}

function addItemToAllFoods($itemnameinput, $itemcategoryinput) {  
    global $db;  

    $authenticated = false;

    try {
        $query = "INSERT INTO item_list VALUES(:itemnameinput, :itemcategoryinput, NULL)";
        $statement = $db->prepare($query);
        $statement->bindValue(':itemnameinput', $itemnameinput);
        $statement->bindValue(':itemcategoryinput', $itemcategoryinput);
        $statement->execute();
        $statement->closeCursor(); 
        $authenticated = true;
    }
    catch (Exception $e) {
        $error_message = $e->getMessage();
        echo "<p>Error message: $error_message </p>";
    }
    return $authenticated;   
}

function addItemToShoppingList($name, $major, $year) {
    global $db;

    $query = "INSERT INTO friends VALUES(:name, :major, :year)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':major', $major);
    $statement->bindValue(':year', $year);
    $statement->execute();
    $statement->closeCursor();    
}



function updateFriend($name, $major, $year)
{
    global $db;

    $query = "UPDATE friends SET major=:major, year=:year WHERE name=:name";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':major', $major);
    $statement->bindValue(':year', $year);
    $statement->execute();
    $statement->closeCursor();    
	
}

function deleteFriend($name)
{
    global $db;

    $query = "DELETE FROM friends WHERE name=:name";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $statement->closeCursor();    
}
?>