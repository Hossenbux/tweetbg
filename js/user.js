 window.addEvent('domready', function(){

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