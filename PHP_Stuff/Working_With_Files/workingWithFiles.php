<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <title>Working with Files</title>
     <meta charset="utf-8">
<style type="text/css">
body {
    margin: 10px;
    padding: 25px;
}

.formLayout {
    background-color: #f3f3f3;
    border: solid 1px #a1a1a1;
    padding: 10px;
    width: 300px;
    height: 115px;
}
    
.formLayout label, .formLayout input {
    display: block;
    width: 120px;
    float: left;
    margin-bottom: 10px;
}
 
.formLayout label {
    text-align: right;
    padding-right: 20px;
}
    
#cmdSubmit {
    margin: 0 100px;
}

.example {
    font-family: monospace;
    color: green;
    font-size: larger;
    font-weight: bold;
}
        
.phpEcho {
    background-color: tan;
    border: thin black solid;
    padding: 25px;
}

br {
    clear: both;
}
</style>
</head>
<body>
<h2>Working with Files</h2>
<div class="phpEcho">
<?php
//var initialization
$arrBooks = array();// used for ul of first 5 books
$arrBooks2 = array();//used for all 10 books
$arrayRewrite = array();//2d array of books
$arrbookFiles = array();//array of files from the directory.
$bookListings = array();//sorted array of books from the arrbookFiles
$tempVar;
$intBookcounter=0;

//for heredoc of additonal books.------------------------------------
$strAdditionalbooks = <<<HERE
\nKILLING REAGAN, by Bill O'Reilly and Martin Dugard
A MORE PERFECT UNION, by Ben Carson with Candy Carson
A COMMON STRUGGLE, by Patrick J. Kennedy and Stephen Fried
M TRAIN, by Patti Smith
ROSEMARY, by Kate Clifford Larson
HERE;
//for heredoc of additonal books.------------------------------------

//original text from NYTimesBestSeller.txt ---------------
//THE SURVIVOR, by Vince Flynn and Kyle Mills
//THE MARTIAN, by Andy Weir
//A KNIGHT OF THE SEVEN KINGDOMS, by George R. R. Martin
//THE MURDER HOUSE, by James Patterson and David Ellis
//SHADOWS OF SELF, by Brandon Sanderson
//--------------------------------------------------------

echo "<h2>New York Times BestSeller Top 5 Books 10-20-2015</h2>";
$handle = fopen("NYTimesBestSeller.txt", "r");
while (!feof($handle)){//converts text file contents into a line by line array $arrBooks
   $arrBooks[] = fgets($handle);
}
fclose($handle);

print "<ul>";
foreach ($arrBooks as $line){
	print "<li>$line</li>";//prints list of books
}
print "</ul>";

//append an additional 5 titles to NYTimesBestSeller.txt
$myfile = fopen("NYTimesBestSeller.txt", "a");
fputs($myfile, $strAdditionalbooks);
fclose($myfile);

//updates the array.
$handle1 = fopen("NYTimesBestSeller.txt", "r");//--------------------
while (!feof($handle1)){//converts text file contents into a line by line array $arrBooks
   $arrBooks2[] = fgets($handle1);
}
fclose($handle1);//---------------------------------------------------

foreach ($arrBooks2 as $line){
	//converts array to string, cleans up string, puts string back into an array ($arrayRewrite) for later use.---------------------
	$tempVar = $line;//string representation of the line
	$tempVar = str_replace(', by ', ' by ', $tempVar);//cleans up string
	$arrayRewrite[] = explode(' by ', $tempVar);//should be a 2d array of freshly parsed strings: book title and author
	//-----------------------------
}

//re display the 10 results and writes a file for each book.
print "<br><h2>Top 10 Books</h2>";
foreach ($arrayRewrite as $arrBook){
	$currentBook ="Book".$intBookcounter.".txt";
	$currentString = "$arrBook[0] by $arrBook[1]";
	print "$arrBook[0] by $arrBook[1] <br>";
	$fileCreator = fopen("$currentBook", "w");
	fputs($fileCreator, $currentString);
	fclose($fileCreator);
	$intBookcounter++;
}
print "<br><br>";

//display directory of newly created 'Book' files.
print"<h3>Newly created list of book files</h3>";
$strcurrentDIRname = getcwd();//current working directory
$currentFilename="";
$dirhandle = opendir($strcurrentDIRname);//makes sure directory is open (i think)
while ($currentFilename = readDir($dirhandle)){
	$arrbookFiles[] = $currentFilename;
}
$bookListings = preg_grep("/^Book/", $arrbookFiles);//creates listing by looking for beginning word "Book"
foreach ($bookListings as $createdBookName){
	print "$createdBookName<br>";
}

?>
</div>
</body>
</html>