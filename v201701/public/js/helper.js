/**
 * 
 * Helper.js
 * 
 */

/**
 * 
 * IIFE - Shorthand for $( document ).ready()
 * IIFE (Immediately Invoked Function Expression) is a JavaScript function that runs as soon as it is defined.
 */
$(function() {
	console.info(new Date() + "helper.js:The DOM is now loaded and can be manipulated.");
	$( "#jsLoaded" ).text( "helper.js: The DOM is now loaded and can be manipulated." );


	/** 
	 * FUNCTIONS (execution when invoked)
	 */
	
	/**
	 * AJAX Call - increment the cart count 
	 * 
	 * WARNING: DEBUGGER(monolog) controler must be set to NOTICE (dev.ini) in order to get no monolog log after the json response from php
	 */
	$('.addToCart').click(function(event){	
		event.preventDefault();
		console.log("starting addToCart");     
		$.ajax( $(this).attr('href') )
		  .done(function(data) {
		    var json = jQuery.parseJSON(data); 					// create an object with the key of the array
		    console.log( "success, cart: " + json.count );
		    $('#cartItemsCount').empty().append(json.count);	// replace cart cart value
		  })
		  .fail(function(data) {
		    alert( "error " + data);
		  })
		  .always(function(data) {
		    console.log( "complete " + data);
		  });

		return false;			// keeps the page from not refreshing 
	});	
	
    /**
     * DATEPICKER
     */
    $('input').filter('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' 
    }); // end datepicker
    
    /**
     * NAV
     */
	$('#todo-trigger').click(function(){
        $(this).next().toggleClass('is-hidden');
        console.log( "todo-trigger");
    });// end todo
    
    $('#todo-input').focusin(function(){ 
        $('#todo-button').toggleClass('is-hidden');  
        console.log( "todo-input");
    });// end todo

    /**
     * SORTABLE - TO DO List
     */
    /*
    $( "#sortable" ).sortable();
    $( "#sortable__index" ).sortable();
    */

    //todo.sortable function
    $('#sortable__index').sortable({
    	axis: 'y',
        opacity: 0.7,
        handle: 'span',  
        update: function(event, ui) {
        	console.log( "sortable__index" );
        }
    });
    
	//todo.sortable function
    $('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',  
        update: function(event, ui) {
            var list_sortable = $(this).sortable('toArray').toString();
            // change order in the database using Ajax
            console.log( "sortable.ajax call: /async/todoClass.php" );
            $.ajax({
                url: 'netricite/async/todoClass.php',
                type: 'POST',
                data: {list_order:list_sortable},
                success: function(data) {
                    //finished
                }
            });
        }
    }); // end sortable

    /**
     * JQUERY-UI : SORTABLE
     */
    $("#sortable li").click(function(){
    	console.log( "sortable li");
    	//var classText=$(this).find('span').text().split(":");
    	var classText=$(this).find('span').text();
    	$('#todo-class').val(classText);  
    	$('#todo-classNew').val(classText);  
    	console.log( "#sortable li" + classText);
    });// end sortable li
    
    $("#sortable__index li").click(function(){
    	console.log( "sortable__index li");
    	//var classText=$(this).find('span').text().split(":");			// span text format 'catégorie:BOOKING'
    	var classText=$(this).find('span').text();
    	$('#todo-class').val(classText[1]);  
    	$('#todo-classNew').val(classText[1]); 
    	
    	console.log( "sortable.ajax call /async/setSessionVariable.php" );

   	    $.ajax({
            url: 'netricite/async/setSessionVariable.php',
            type: 'GET',
            //data: {variable:'todoClass', value:classText[1]},			// span text format 'catégorie:BOOKING'
            data: {variable:'todoClass', value:classText},
            success: function(text) {
            	location.reload(); //refresh page          	
            }
        });
    });// end sortable li	    
    
    
    /**
     * 
     * CLEAR TEXT - Return-code message (see rightPanel.php) is cleanup after 8 seconds
     * 
     */
    function clearReturnCode() {
    	/*
	 	  $.ajax({
	          url: 'netricite/async/unsetSessionVariable.php',
	          type: 'POST',
	          data: {variable:'info'},
	          success: function(data) {
	          	console.log( "clearReturnCode" );
	              //finished
	          }});
	 	  $('#returnCode').text("");
	 	  */
     	};  // end clearReturnCode
     	
    /**
     * POPUP OPEN
     * 
     */
   function openPopup(page,name,option) {
	   		console.log("open popup");
            window.open(page,name,option);
         }
   
 //GOOGLE SCRIPT
   function signOut() {
       var auth2 = gapi.auth2.getAuthInstance();
       auth2.signOut().then(function () {
         	console.log('vTemplate.signOut() - User signed out.');
         	//click signoff button to complete application signoff
       	//$( "#signoff" ).click();
       });
     }
   function onSignIn(googleUser) {
     var profile = googleUser.getBasicProfile();
     //console.log("ID: " + profile.getId()); // Don't send this directly to your server!
     //console.log('Full Name: ' + profile.getName());
     //console.log('Given Name: ' + profile.getGivenName());
     //console.log('Family Name: ' + profile.getFamilyName());
     //console.log("Image URL: " + profile.getImageUrl());
     //console.log("Email: " + profile.getEmail());

     //document.getElementById('fbstatus').innerHTML =
     //    'Merci de vous logger, ' + profile.getGivenName + '!';
     
	  var info = {'fullname' : profile.getName(), 'familyname' : profile.getFamilyName(), 'givenname' : profile.getGivenName(),
			  'img' : profile.getImageUrl(), 'email' : profile.getEmail()};      
     //load session info 
     $.ajax({
 		url: 'netricite/async/asyncSocialLogin.php',
 		type: 'POST',
 		data: {profile:info},
 		success: function(data) {		
 			console.log( "onSignIn completed" );
 		}});
   }
   
   //BOOTSTRAP TOOLTIP
   //bootstrap tooltip initialization
   $('[data-toggle="tooltip"]').tooltip();
   
   //BOOTSTRAP PAGE
   // Add smooth scrolling to all links in navbar + footer link
   $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
   	/**
      	 * BOOTSTRAP PAGE ANIMATE
      	 * 
      	 */
       // Make sure this.hash has a value before overriding default behavior
       if (this.hash !== "") {

         // Prevent default anchor click behavior
         event.preventDefault();

         // Store hash
         var hash = this.hash;

         // Using jQuery's animate() method to add smooth page scroll
         // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
         $('html, body').animate({
           scrollTop: $(hash).offset().top
         }, 900, function(){

           // Add hash (#) to URL when done scrolling (default click behavior)
           window.location.hash = hash;
           });
         } // End if
       }); // end navbar click
   	
    /**
     * IIFE - CODE IS EXECUTED WHEN IT IS INITIALIZED
     * 
     */
    //setTimeout(clearReturnCode, 10000);     //for test purpose, executed once after 10 sec

    //Validator plugin (formValidator.js
    //console.log("call formValidator plugin");
    //$(document).formValidator();
    //$( document ).ready( formValidator );   

    /**
     * ACCORDION
     * 
     */
    /* Toggle between adding and removing the "active" and "show" classes when the user clicks on one of the "Section" buttons. The "active" class is used to add a background color to the current button when its belonging panel is open. The "show" class is used to open the specific accordion panel */
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function(){
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
        }
    }
    
});	//end of shorthand



