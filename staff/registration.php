<?php
//session_start();
//include "session.php";
include "../libcommon/conf.php";
include "../libcommon/classes/form.cls.php";
include "../libcommon/classes/paginator.cls.php";
include "../libcommon/classes/sql.cls.php";
include "../libcommon/classes/db_mysql.php";
include "../libcommon/classes/package.cls.php";
include "../libcommon/functions.php";
include "../libcommon/calendar_function.php";
include "../libcommon/db_inc.php";

$cForm = new InputForm();
$cPage = new paginator();
$cPkg = new Package();
$cSQL = new SQL();
$PATH = $_GET["menu"];
include "header.php";
?>




<script>

  $(function() {
    $("#datepicker").datepicker();
  });

  function hai()
  {

  	alert('manu');
  }

	function insert()
			{
				var error = validate();
				if(error==true)
				{

					var dataString = ""
					var name = $('#textname').val()
					var password = $('#password').val()
					var address = $('#address').val()
					var sex = $('#sex').val()
					var district = $('#district').val()
					var state = $('#state').val()
					var pincode = $('#pincode').val()
					var email = $('#emailid').val()
					var dob = $('#datepicker').val()
					var mob = $('#mobileno').val()
					dataString = "name="+name+"&password="+password+"&address="+address+"&sex="+sex+"&district="+district+"&state="+state+"&pincode="+pincode+"&email="+email+"&dob="+dob+"&mob="+mob;
					//alert(dataString);

					$.ajax({
							type:"POST",
							url: "create_newuser.php",
							data:dataString,
							success: function(response){
		 					$('#head').after(response);
		                               }
		
			
	                    	});
		

				}
				else
					{
					 alert("not inserted");
					}						 
			}


function validate()
{ 
   if( document.StudentRegistration.textname.value == "" )
   {
     alert( "Please provide your Name!" );
     document.StudentRegistration.textname.focus() ;
     return false;
   }

   
   if( document.StudentRegistration.address.value == "" )
   {
     alert( "Please provide your Postal Address!" );
     document.StudentRegistration.address.focus() ;
     return false;
   }
   

   if ( ( StudentRegistration.sex[0].checked == false ) && ( StudentRegistration.sex[1].checked == false ) )
   {
   alert ( "Please choose your Gender: Male or Female" );
   return false;
   }    
   if( document.StudentRegistration.district.value == "-1" )
   {
     alert( "Please provide your Select District!" );
    
     return false;
   }   
   if( document.StudentRegistration.state.value == "-1" )
   {
     alert( "Please provide your Select State!" );
     
     return false;
   }
   if( document.StudentRegistration.pincode.value == "" ||
           isNaN( document.StudentRegistration.pincode.value) ||
           document.StudentRegistration.pincode.value.length != 6 )
   {
     alert( "Please provide a pincode in the format ######." );
     document.StudentRegistration.pincode.focus() ;
     return false;
   }
 var email = document.StudentRegistration.emailid.value;
  atpos = email.indexOf("@");
  dotpos = email.lastIndexOf(".");
 if (email == "" || atpos < 1 || ( dotpos - atpos < 2 )) 
 {
     alert("Please enter correct email ID")
     document.StudentRegistration.emailid.focus() ;
     return false;
 }
  if( document.StudentRegistration.dob.value == "" )
   {
     alert( "Please provide your DOB!" );
     document.StudentRegistration.dob.focus() ;
     return false;
   }
  if( document.StudentRegistration.mobileno.value == "" ||
           isNaN( document.StudentRegistration.mobileno.value) ||
           document.StudentRegistration.mobileno.value.length != 10 )
   {
     alert( "Please provide a Mobile No in the format 123." );
     document.StudentRegistration.mobileno.focus() ;
     return false;
   }
   return( true );
}

</script>



<body>
<center>
<h2>Registration Form</h2>
</center>
<div id="head">
</div>
<div class="row">
<div class="col-md-offset-4 col-md-4 col-md-offset-4">
<form name="StudentRegistration" id="form" >

<div class="form-group">
<label for="name">Name</label>
<input type=text class="form-control" name="name" id="textname" placeholder="Entername">
</div>


<div class="form-group">
<label for="password">Pasword</label>
<input type=password class="form-control" name="password" id="password"  placeholder="Enter password">
</div>

<div class="form-group">
<label for="address">Address</label>
<textarea id="address" name="address" class="form-control" rows="3"></textarea>
</div>

<div class="radio">
<input type="radio" name="sex" value="male" id="sex">Male
</div>

<div class="radio">
<input type="radio" name="sex" value="Female" id="sex">Female
</div>

<div>
<label for="district">District</label>
<select class="form-control" name="district" id="district">
<option value="-1" selected>select</option>
<option value="Nalanda">NALANDA</option>
<option value="UP">UP</option>
<option value="Goa">GOA</option>
<option value="Patna">PATNA</option>
</select>
</div>



<div>
<label for="state">State</label>
<select class="form-control" name="state" id="state">
<option value="-1" selected>select..</option>
<option value="New Delhi">NEW DELHI</option>
<option value="Mumbai">MUMBAI</option>
<option value="Goa">GOA</option>
<option value="Bihar">BIHAR</option>
</select>
</div>

<div class="form-group">
<label for="password">Pincode:</label>
<input type="text" name="pincode" id="pincode"  class="form-control" placeholder="pincode">

<div class="form-group">
<label for="password">EmailId:</label>
<input type="text" name="emailid" id = "emailid"  class="form-control" placeholder="email">
</div>
<div class="form-group">
<label for="dob">dob:</label>
<td><input type="text" id="datepicker"  class="form-control" name = "dob" placeholder="DOB">
</div>
<div class="form-group">
<label for="mob">mob:</label>
<input type="text" name = "mobileno" id="mobileno"  class="form-control" placeholder="MOB">
</div>
<input type="button" id='insertBtn' value="Submit" onclick="insert()" class="btn btn-default" >
</form>
</div>
</div>
</body>
</html>