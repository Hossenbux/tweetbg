 window.addEvent('domready', function(){
 	
 	//edit mode
 	// document.getElement('.auth').addEvent('click', function(event){
 		// event.preventDefault();
		// window.open('auth','Twitter','width=700,height=300');
	// });
	
	window.addEvent('authSuccess', function(event){
		window.location = "user";
	});
	
	document.getElement('.getSample').addEvent('click', function(event){
        new Request({
            'url': 'builder/sample/500px/coffee',
            'method': 'GET',
            'onSuccess': function(img) {
                document.getElement('.sample').adopt(new Element('img', {'src': '/'+img}))
            }
        }).send();
    });
	
	window.addEvent('deleteSample', function(event){
	    
	});
	
	
	
});