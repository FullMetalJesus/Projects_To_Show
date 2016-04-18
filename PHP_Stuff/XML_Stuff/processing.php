<?php
session_start();

if (isset($_POST["isbn10"])){// executes the script if the first form was filled out and submitted, else send backs to start.php.

//-------basic variable creation-------
    $_SESSION["isbn10"] = $_POST["isbn10"];
    $_SESSION["title"] = $_POST["title"];
	$_SESSION["fName"] = $_POST["fName"];
    $_SESSION["lName"] = $_POST["lName"];
	$_SESSION["publication_date"] = $_POST["publication_date"];
	$_SESSION["price"] = $_POST["price"];
	
	$isbn10 = $_POST["isbn10"];
    $title = $_POST["title"];
    $fName = $_POST["fName"];
	$lName = $_POST["lName"];
    $publication_date = $_POST["publication_date"];
    $price = $_POST["price"];
///------------------------------------
//---------derived variables----	
	$authorName = $lName.", ".$fName;
    $_SESSION["authorName"] = $authorName;
	$_SESSION['message'] = "";
   
    $blnFound = false; // create a Boolean variable to determine if the book has been found
	//--------------------------
    
    // check to see if the XML document exists using filesystem methods
    if (!file_exists ("myXML.xml")){
        // file does not exist so create the XML file
        // create the XML declaration and root elements
        $xmlString = "<?xml version=\"1.0\" encoding=\"utf-8\"?><books></books>";
        
        // create a new SimpleXML Object
        $xml = new SimpleXMLElement($xmlString);
        
        // Save the file to the directory
        $xml->asXML('myXML.xml');
    }
    
    // load the XML document.
    $xml = simplexml_load_file("myXML.xml");
    
    // loop through all of the isbn10 values in the document to see if the provided isbn10 is in one of the records
    foreach ($xml->children() as $sec_gen){
        // assign a variable to the isbn10 value
        $value = $sec_gen->isbn10;
        
        // checks to see if the isbn10 value in the XML document is the same as the isbn10 submitted, the book has registered before
        if ($value == $isbn10){
            $blnFound = true;
        }
    }
    // if the boolean variable remains false, then the book was not found
    // write a new child to the XML document 
    if (!$blnFound){
        $book = $xml->addChild('book');
        $addIsbn10 = $book->addChild('isbn10', $isbn10);
		$addTitle = $book->addChild('title', $title);
        $addAuthor = $book->addChild('author', $authorName);
        $addDate = $book->addChild('publication_date', $publication_date);
        $addPrice = $book->addChild('price', $price);
        
        // write the updated XML document to the file system
        $xml->asXML('myXML.xml');
        
        $_SESSION["message"] = "Book registration successful";
    }
    else {
        // book was found in the existing XML document
    
        $_SESSION['message'] = "The book you provided is already in our records, via isbn-10 comparison";
            
    }
    header('Location:display.php'); // redirect the display page
}
else {// user has arrived by another means and needs to be sent back to start.php
    header('Location:start.php');
}
?>