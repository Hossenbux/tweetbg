 window.addEvent('domready', function(){

    document.getElement('.getSample').addEvent('click', function(event){
    	
    	var source =  document.getElements("[name=source]:checked").get("value");
    	var sampleimg = document.getElement(".sample-img");
    	var preload = new Element('img', {id: "loading","src":"/images/preload.gif"})
    	document.getElement('.getSample').inject( preload , "after");
           
    	
        new Request({
            'url': 'builder/sample/'+source+'/pool',
            'method': 'GET',
            'onSuccess': function(img) {
            	
            	if( sampleimg )
            	{
            		document.getElement(".sample-img").set("src", img)
            	} 
            		else 
            	{
            		document.getElement('.sample').adopt(new Element('img', { src: '/'+img, 'class': 'sample-img'}))
            	}
                document.getElement('#loading').destroy();
            }
        }).send();
    });
    
     document.getElement('.logout').addEvent('click', function(event){
        new Request({
            'url': 'user/logout',
            'method': 'GET',
            'onSuccess': function(response) {
                window.location = "home";
            }
        }).send();
    });
    
    document.getElement('form[name=options]').addEvent('submit', function(event){
        event.preventDefault();

        new Request({
            'url': 'user/saveSettings/'+this.getElement('[name=source]:checked').value+'/'+this.getElement('[name=search]:checked').value,
            'method': 'PUT',
            'onSuccess': function(img) {
                //do something cool
            }
        }).send();
    });
    
    window.addEvent('deleteSample', function(event){
        
    });
    
    
    
});