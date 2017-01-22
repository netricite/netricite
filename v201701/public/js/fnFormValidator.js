/**
 * JS for registration screen
 * control user input
 */

/**
 * tooltips are deplayed only in case of error
 */
function deactivateTooltips() {
	//console.log('fnFormValidator.js, deactivateTooltips.');
	var spans = document.getElementsByTagName('span'), spansLength = spans.length;

	for (var i = 0; i < spansLength; i++) {
		if (spans[i].className == 'userMessage') {
			spans[i].style.display = 'none';
		}
	}
}

/**
 * display tooltip corresponding to user input
 */
function getTooltip(element) {
	if (element ==null) {
		  console.log("getTooltip, field not checked");
		  return false;
	  } 
	console.log('element[' + element.id +  '] value:' + element.value);
    while (element = element.nextSibling) {
    	
        if (element.className === 'userMessage') {
        	console.log('tooltip:' + element.innerHTML );
            return element;
        }
    }
    console.log('no tooltip');
    return false;
}

/**
 *  input field validator
 */
function inputValidator(input, validationFunction) {
	if (input ==null) {
		  console.log("inputValidator, field not checked");
		  return true;
	  } 
  console.log("inputValidator.input:" + input.value + validationFunction);
  if(validationFunction(input))  {
	    return valid(input);
	  }
	  else {
		return invalid(input);
	  }
 
};

/**
 *  valid input 
 *  
 *  @return true
 */
function valid(input) {
	if (input ==null) {
		  console.log("valid, field not checked");
		  return true;
	  } 
  var tooltipStyle = getTooltip(input).style;
 
  input.className = 'form-control';
  tooltipStyle.display = 'none';
  console.log("valid input(" + input.id + ")"); 
  return true; 
 
};

/**
 *  invalid input 
 *  
 *  @return false
 */
function invalid(input) {
	if (input ==null) {
		  console.log("invalid, field not checked");
		  return true;
	  } 
  var tooltipStyle = getTooltip(input).style;
 
  input.className = 'form-control has-error has-feedback';
  tooltipStyle.display = 'inline-block';
  console.log("invalid input(" + input.id + ")"); 
  return false;
  
};

/**
 * generic regex input validation
 */
function isValidInput(input, format) {
	if (input ==null) {
		  console.log("isValidInput, field not checked");
		  return true;
	  } 
	console.log("isValidInput.input:" + input.value + " format: " + format);
	if (input.value.match(format)) {
		return true;
	} else {
		input.focus();
		return false;
	}
}
/**
 * alphabetic validation (space and - character are authorized)
 */
function isAlphabetic(input) {
	var format = /^[A-Za-z -]+$/;
	return isValidInput(input, format);
}

/**
 * numeric validation space is authorized
 */
function isNumeric(input) {
	var format = /^[0-9 ]+$/;
	return isValidInput(input, format);
}

/**
 * numeric validation space is authorized
 */
function isValidSize(input, min, max) {
	//var format = /^.{5,10}$/;						//working
	var format = new RegExp('^.{' + min + ',' + max + '}$');
	return isValidInput(input, format);
}

/**
 * 
 * @param date
 * @returns
 */
function isValidDate(input) {
	if (input ==null) {
		  console.log("isValidDate, field not checked");
		  return true;
	  } 
	console.log("isValidDate.input:" + input.value );
	//jj-mm-AAAA
	var format = /^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/g;
	//^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$ 		// YYYY-mm-dd
	if (format.test(input.value)) {
        return true;
    } else {
        return false;
    }
}

/**
 * email validation
 */
function isValidEmail(input) {
	var format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	return isValidInput(input, format);
}

/**
 * phone validation
 */
function isValidPhone(input) {
	var format = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
	return isValidInput(input, format);
}

/**
 * email validation
 */
function isValidPassword(input) {
	/*
	 * check a password between 7 to 16 characters which contain 
	 * -only characters, 
	 * -numeric digits, underscore 
	 * -first character must be a letter
	 */
	  //var format=  /^[A-Za-z]\w{7,14}$/;  
	  /*
	   * check a password between 6 to 20 characters which contain: 
	   * -at least one numeric digit, 
	   * -one uppercase
	   * -one lowercase letter
	   */
	var format = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;  
	return isValidInput(input, format);
}

/**
 * Form control functions, return "true" if valid input
 */ 
var check = {};     // all functions are loaded in check array.
/**
 * check "address" input field
 */
check['novalidation'] = function(id) {
	var input = document.getElementById(id);
	//console.log("*** no validation ***");
  	return valid(input);

};
/**
 * check "email" input field
 */
check['email'] = function(id) {
	  var input = document.getElementById(id);
	  return inputValidator(input,isValidEmail );
};

/**
 * check "pseudo" input field
 */
check['pseudo'] = function(id) {
  var input = document.getElementById(id);
  if (isValidSize(input, 2, 20 )) {
	  return valid(input);
  } else {
	  return invalid(input);
  }

};

/**
 * check "password" input field
 */
check['pwd'] = function(id) {
  var input = document.getElementById(id);
  console.log("*** forced valid input for test purpose ***");
  return valid(input); /*  @@@ to be removed for PRODUCTION
  
  /*  @@@ to be activated for PRODUCTION
  if(isValidPassword(input))  {
	  return valid(input);
  } else {
	  return invalid(input);
  }
  */
};

/**
 * check "confirmation password" input field
 */
check['passwordConfirm'] = function(id) {
  var pwd1 = document.getElementById('pwd'), 
      pwd2 = document.getElementById(id), 
      tooltipStyle = getTooltip(pwd2).style;
  if (pwd1 ==null || pwd2 ==null) {
	  console.log("passwordConfirm, field not checked");
	  return true;
  } 

  if (pwd1.value == pwd2.value && pwd2.value != '') {
	  return valid(pwd2);
  } else {
	  return invalid(pwd2);
  }

};

/**
 * check "lastname" input field
 */
check['lastname'] = function(id) {
  var input = document.getElementById(id);
  return inputValidator(input,isAlphabetic );

};

/**
 * check "firstName" input field; name and first name are controlled with the same function
 */
check['firstname'] = check['lastname'];

/**
 * check "phone" input field
 */
check['phone'] = function(id) {
  var input = document.getElementById(id);
  return inputValidator(input,isValidPhone );

};

/**
 * check "address" input field
 */
check['address'] = function(id) {
	var input = document.getElementById(id);
	//console.log("*** no validation ***");
  	return valid(input);

};

/**
 * check "city" input field
 */
check['city'] = function(id) {
  var input = document.getElementById(id);
  return inputValidator(input,isAlphabetic );

};

/**
 * check "country" input field
 */
check['zipcode'] = function(id) {
	var input = document.getElementById(id);
	//console.log("*** no validation ***");
	return valid(input);

};

/**
 * check "country" input field
 */
check['country'] = function(id) {
  var input = document.getElementById(id);
  if (input ==null) {
	  console.log("country, field not checked");
	  return true;
  } 
  
  if (input.options[input.selectedIndex].text != 'none') {
    return valid(input);
  } else {
    return invalid(input);
  }

};

/**
 * check "languga" input field
 */
check['language'] = function(id) {
  var input = document.getElementById(id);
  if (input ==null) {
	  console.log("language, field not checked");
	  return true;
  } 
  if (input.options[input.selectedIndex].value != 'none') {
    return valid(input);
  } else {
    return invalid(input);
  }

};

/**
 * check "date" input field - valid by definition
 */
check['datepicker'] = function(id) {
  var input = document.getElementById(id);
  if (input ==null) {
	  console.log("language, field not checked");
	  return true;
  } 
  return valid(input);
};

/**
 * check "date" input field  format jj-mm-AAAA
 */
check['europeanDate'] = function(id) {
  var input = document.getElementById(id);

  if (isValidDate(input)) {
    return valid(input);
  } else {
    return invalid(input);
  }

};
/**
 * load event: use an IIFE replacing global variables.
 * (Immediately-invoked function expression) automated script activation
 * 
 */
(function() { 
	/**
	 * Generate event handler for every above check
	 */
	var myForm = document.getElementsByTagName('form'), 		/* myForm = document.getElementById('registration'), */
		inputs = document.querySelectorAll('input[type=text], input[type=password]'),
		inputsLength = inputs.length;
	for (var j = 0 ; j < myForm.length ; j++) { 	
	  console.log("Checking myForm(" + myForm[0].getAttribute('name')+")");
	  for (var i = 0 ; i < inputsLength ; i++) {
		  //console.log ("myForm.check: " + inputs[i].id );
          inputs[i].addEventListener('keyup', function(e) {
            	console.log( "check[" + e.target.id + "] value: " + e.target.value);
            	if ($.isFunction(check[e.target.id])) {
            		 check[e.target.id](e.target.id); // "e.target" représente l'input actuellement modifié
            	} else {
            		check["novalidation"](e.target.id);
            	}
              }, false);
      }
	}  
	//console.log("Add event submit");
	myForm[0].addEventListener('submit', function(e) {
		var result = true;
		for ( var i in check) {
			console.log("**--> Checking("+i+")");
			result = check[i](i) && result;
			console.log("**--> Result("+result+")");
		}

		if (result) {
   			alert('Form has been checked successfully.');
   			//submit the form
   			myForm[0].submit();
   		} else {
   			alert('please correct errors before submission');
   			e.preventDefault();
   			}
		
	}, false);

	//console.log("Add event reset");
	myForm[0].addEventListener('reset', function() {
	
		for (var i = 0; i < inputsLength; i++) {
			if (inputs[i].type == 'text'
				|| inputs[i].type == 'password') {
				inputs[i].className = '';
			}
		}
		deactivateTooltips();
	}, false);
	console.log("fnFormValidator;IIFE completed with success");
})(); // end IIFE

/**
 * initialization completed, the tooltips are deactivated
 */
deactivateTooltips();

console.log('fnFormValidator.js, events loaded.' + Date() );
