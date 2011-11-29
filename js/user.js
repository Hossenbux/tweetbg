 window.addEvent('domready', function(){

    document.getElement('.getSample').addEvent('click', function(event){
    	var sample = document.getElement('.sample-image').addClass('loading');
    	var source =  document.getElements("[name=source]:checked").get("value");
    	var term = document.getElement('[name=term]').value;
    	if(term.length == 0) term = "coffee";
        new Request({
            'url': 'builder/sample/'+source+'/'+term,
            'method': 'GET',
            'onRequest': function(){
                sample.addClass('loading');
                sample.empty();
            },
            'onSuccess': function(img) {                
                sample.removeClass('loading')
                sample.adopt(new Element('img', { src: '/'+img, 'class': 'sample-img'}))
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
                document.getElement('.success').wink(2000);
            }
        }).send();
    });
    

    document.getElements('.fadeout').addEvent('click', function(event){
        event.preventDefault();
        this.getParent('.alert-message').nix('true');
    });

});