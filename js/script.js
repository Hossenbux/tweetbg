 window.addEvent('domready', function(){
 	
 	//edit mode
 	document.getElement('.auth').addEvent('click', function(event){
 		event.preventDefault();
		window.open('auth','Twitter','width=700,height=300');
	});
	
	window.addEvent('authSuccess', function(event){
		new Element('h1', {'html': 'You are now connected to tweetbg'}).inject(document.body);
	});
	
});