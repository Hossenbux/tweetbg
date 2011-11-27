window.addEvent('domready', function(){
    //edit mode
    document.getElement('.auth').addEvent('click', function(event){
        event.preventDefault();
        window.open('auth','Twitter','width=700,height=300');
    });
});