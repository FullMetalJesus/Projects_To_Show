/* -------------------------------------------
function: chkForm(formNum)
purpose:  to check that minimum form requirements have been meant
author:    altered version of Marti Bakers
date:      3-10-2015
paramters: formNum as an integer, representing the index of the form in the form array
---------------------------------------------*/
function chkForm(formNum) {
    // capture the number of elements in the form
    var intElements = document.forms[formNum].elements.length;
    
    // global variables for password field
    var strBadPass = false;
    
    for (var i = 0; i < intElements; i++){// loop through all the elements to verify information
       
	   // check to see that all required fields are filed in, a blank field sets a warning and returns false to prevent processing to the next page
		var strCurrString = document.forms[formNum].elements[i].value;
		
		if(document.forms[formNum].elements[i].name != "adminLevel"){//only executes if its not a 'select' element called "adminlevel" which holds a single digit (found in addAdmin.php)
			if ( (strCurrString == "") || (strCurrString.length<=3) ){
				document.getElementById("loginWarn").innerHTML = "A field is either empty, less than 3 characters or not selected. admin.js chckForm.";
				document.forms[formNum].elements[i].focus();
				return false;
			}
		}
        
        if (document.forms[formNum].elements[i].name == "pswWord"){//checks main password field when present.
            // capture the value typed into the password input field
            var strPass = document.forms[formNum].elements[i].value;
            
            // Use a regular expression (re) to test for:
            // numbers (?=.*\d)
            // lower case letters (?=.*[a-z])
            // upper case letters (?=.*[A-Z])
            // special characters (?=.*[!@#$%&*()])
            // must be at least 8 characters {8,}
            re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&*()]).{8,}/; 
            if(!re.test(strPass)) { 
                strBadPass = true;//bad password here.
            }
        }
		//checks the for password matching when a confirm field is present.
		if (document.forms[formNum].elements[i].name == "pswConf"){
            if (document.forms[formNum].pswConf.value != document.forms[formNum].pswWord.value){
                document.getElementById("loginWarn").innerHTML = "Passwords do not match.admin.js chckForm.";
                document.forms[formNum].pswConf.value == "";
                document.forms[formNum].pswWord.value == "";
                document.forms[formNum].pswWord.focus();
                return false;
            }
			//makes sure old password doesnt equal new password when old password field is present.
			if (document.forms[formNum].pswConf.value == document.forms[formNum].pswOld.value || document.forms[formNum].pswWord.value == document.forms[formNum].pswOld.value){
                document.getElementById("loginWarn").innerHTML = "The new password must be different than the old password. admin.js chckForm.";
				document.forms[formNum].pswOld.value == "";
                document.forms[formNum].pswConf.value == "";
                document.forms[formNum].pswWord.value == "";
                document.forms[formNum].pswWord.focus();
                return false;
            }
        }
    }//end of for loop  
    if (strBadPass){//if there was a bad password.
        document.getElementById("loginWarn").innerHTML = "Your password does not meet minimum requirements for passwords. admin.js chckForm.";
        document.forms[formNum].pswWord.value = "";
        document.forms[formNum].pswWord.focus();
        return false;
    }
    else{//everything should be fine.
    // used for testing
    //alert("completed");
    //return false;
    
	//clrErr("loginWarn"); seems to be causing problems, dont understand why, logically..
    return true;
	}
}

/*  **************************************************
function:   clrErr(fieldName)
purpose:    clear the warning message
author      mbaker
date:       1-2-2015
parameters: fieldName as a string, representing the field name
***************************************************** */
function clrErr(fieldName) {
    // clear the warning from the web page
    document.getElementById(fieldName).innerHTML = "";
    
    // return true to acknowledge that the function is complete
    return true;
}