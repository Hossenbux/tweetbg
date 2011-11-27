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
            'url': 'user/save/'+this.getElement('[name=source]:checked').value+'/'+this.getElement('[name=search]:checked').value,
            'method': 'PUT',
            'onSuccess': function(img) {
                //do something cool
            }
        }).send();
    });
    
    window.addEvent('deleteSample', function(event){
        
    });
    
    
    
});