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
        //document.getElement('.getSample').fireEvent('click');
        
    });
    
    document.getElement('.save').addEvent('click', function(event){
        event.preventDefault();
        new Request({
            'url': 'user/saveSettings/'+document.getElement('[name=source]:checked').value+'/'+document.getElement('[name=search]:checked').value,
            'method': 'PUT',
            'onSuccess': function(img) {
                //do something cool
                document.getElement('.success').wink(2000);
            }
        }).send();
    })
    
    document.getElements('.fadeout').addEvent('click', function(event){
        event.preventDefault();
        this.getParent('.alert-message').nix('true');
    });
    
    document.getElement('ul').addEvent('click:relay([type=radio])', function(event){
        source = document.getElement('.source-description');
        search = document.getElement('.search-description');
        document.getElement('.'+this.name+'-description').reveal();
        switch(this.value){
            case '500px':
                source.set('html', '<strong>Recommended!</strong><br> 500px is a photographic community powered by creative people from all over the world that lets you share and discover inspiring photographs and most definitely has the highest quality collection of photos.')
                break;
            case 'Flickr':
                source.set('html', '<strong>Sure!</strong><br> Flickr is a popular image hosting site that has a massive community of users. We recommended this service for more generic photos and good with string search.')
                break;
            case 'Google':
                source.set('html', '<strong>Okay!</strong><br> Google has a collection of almost every photo on the internet which also means a lot of junk. Works best with string search.')
                break;
           case 'Keyword':
                search.set('html', '<strong>Keyword</strong><br> searches your latest tweet for words containing an asterix(*) and creates a collage of photos based on search results from your chosen source using that word.')
                break;
           case 'String':
                search.set('html', '<strong>String</strong><br> gets your latest tweet and creates a collage of photos based on search results from your chosen source using that word.')
                break;
        }
    })

});