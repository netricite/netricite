/**
 * 
 * Helper.js
 * 
 */

/**
 * 
 * IIFE - Shorthand for $( document ).ready()
 * 
 */
$(function() {
	/**
     * DEBUG 
     */
    $('.debug').click(function(event){	
		alert('Debug  click img');
	return false;
    }); // end debug
 
    /**
     * DATEPICKER
     */
    $('input').filter('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' 
    }); // end datepicker
    
    //BOOTSTRAP TOOLTIP
    //bootstrap tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
    
    //BOOTSTRAP PAGE
    // Add smooth scrolling to all links in navbar + footer link
    $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    	
    /**
     * TODO
     */
    /*
	$('#todo-trigger').click(function(){
        $(this).next().toggleClass('is-hidden');
    });// end todo
    
    $('#todo-input').focusin(function(){ 
        $('#todo-button').toggleClass('is-hidden');  
    });// end todo
	*/   
    
    /**
     * JQUERY-UI : SORTABLE
     */
    $("#sortable li").click(function(){
    	//var classText=$(this).find('span').text().split(":");
    	var classText=$(this).find('span').text();
    	$('#todo-class').val(classText);  
    	$('#todo-classNew').val(classText);  
    	console.log( "#sortable li");
    });// end sortable li
    
    $("#sortable__index li").click(function(){
    	//var classText=$(this).find('span').text().split(":");			// span text format 'catégorie:BOOKING'
    	var classText=$(this).find('span').text();
    	$('#todo-class').val(classText[1]);  
    	$('#todo-classNew').val(classText[1]); 
    	
    	console.log( "#sortable.ajax call /async/setSessionVariable.php" );

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
    
    //todo.sortable function
    $('#sortable__index').sortable({
    	axis: 'y',
        opacity: 0.7,
        handle: 'span',  
        update: function(event, ui) {
        	console.log( "#sortable__index" );
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
            console.log( "#sortable.ajax call: /async/todoClass.php" );
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
    /* a voir si utile pour "sortable"?
        $( "#sortable" ).disableSelection({
    	
    	}); // end disableSelection
      } );
      */
    
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
    
    /**
     * IIFE - CODE IS EXECUTED WHEN IT IS INITIALIZED
     * 
     */
    //setTimeout(clearReturnCode, 10000);     //for test purpose, executed once after 10 sec

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
     * GOOGLE MAPS
     * 
     */
    /*
    var myCenter = new google.maps.LatLng(46.158622, 6.669988);

    function initGoogleMap() {
    var mapProp = {
    center:myCenter,
    zoom:18,
    scrollwheel:true,
    draggable:true,
    mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

    var marker = new google.maps.Marker({
    position:myCenter,
    });

    marker.setMap(map);
    }
	
    // initialization
    google.maps.event.addDomListener(window, 'load', initGoogleMap);
    */
    
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



