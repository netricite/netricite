/* Google auth management */

function handleClientLoad() {
	// Loads the client library and the auth2 library together for efficiency.
	// Loading the auth2 library is optional here since `gapi.client.init` function will load
	// it if not already loaded. Loading it upfront can save one network request.
	gapi.load('client:auth2', initClient);
}

function initClient() {
	// Initialize the client with API key and People API, and initialize OAuth with an
	// OAuth 2.0 client ID and scopes (space delimited string) to request access.
	gapi.client.init({
		clientId: '530780569881-5ndq0508il1k82qjpp4ttvo9uaqmak4i.apps.googleusercontent.com',
		scope: 'profile'
	}).then(function () {
		// Listen for sign-in state changes.
		gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

		// Handle the initial sign-in state.
		updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
	});
}

function updateSigninStatus(isSignedIn) {
	// When signin status changes, this function is called.
	// If the signin status is changed to signedIn, we make an API call.
	if (isSignedIn) {
		makeApiCall();
	}
}

/**
 * google signin
 * 
 * @param event
 */
function handleAuthClick(event) {
	// Ideally the button should only show up after gapi.client.init finishes, so that this
	// handler won't be called before OAuth is initialized.
	console.log("signIn");
	gapi.auth2.getAuthInstance().signIn();
	//Redirect to homepage
}

/**
 * google "signout"
 * generates application "logout"
 * 
 * @param event
 */
function handleSignoutClick(event) {
	console.log("signOut");
	gapi.auth2.getAuthInstance().signOut();
	$( "#signoff" ).click();
}

/**
 * Get google profile
 * ajax to set session variable (pseudo, img)
 * 
 */
function makeApiCall() {
	// Make an API call to the People API, and print the user's given name.
	googleUser=gapi.auth2.getAuthInstance().currentUser.get();
	var profile = googleUser.getBasicProfile();
	console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	console.log('Name: ' + profile.getName());
	console.log('Image URL: ' + profile.getImageUrl());
	console.log('Email: ' + profile.getEmail());

	$.ajax({
		url: 'netricite/async/asyncGoogleLogin.php',
		type: 'POST',
		data: {profile:profile},
		success: function(data) {
			$('#info').text("Authentified by Google");		
			console.log( "onSignIn completed" );
			//$( "#login-home" ).click();
		}});
	
	/*  add a <p> with email
	    var p = document.createElement('p');
	    p.appendChild(document.createTextNode('Hello, '+profile.getEmail()+'!'));
	    document.getElementById('login').appendChild(p);
	 */
}

