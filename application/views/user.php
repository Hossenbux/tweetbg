
<div class="settings container">
    
    <div class="alert-message success fade in" data-alert="alert">
        <a class="fadeout close" href="#">×</a>
        <p><strong>Success!</strong> Your settings have been saved.</p>
    </div>
    
    <div class="alert-message danger fade in" data-alert="alert">
        <a class="fadeout close" href="#">×</a>
        <p><strong>Uh-oh!</strong> Something went wrong. Please try again.</p>
    </div>
   
    <div class="alert-message block-message error fade in" data-alert="alert">
        <a class="fadeout close" href="#">×</a>
        <p><strong>Oh hai der!</strong> Thank you for using our application. We are currently developing the app further to me more dynamic and customizable. Feel free to checkout our list of features by clicking the button below.</p>
        <div class="alert-actions">
          <button class="btn small more">Learn more</button> <button class="btn small fadeout">Close</button>
        </div>
    </div>
    
    <img src="<?= $avatar ?>">
    <h1>Hello <?= $screen_name ?>,</h1>
    
    
    <form name="options" method="PUT" action="user">
        <div class="source">
            <h2>Choose your photo source.</h2>
            <ul class="unstyled">
                <li><input name="source" type="radio" value="500px" <?= $source == '500px' ? "checked" : "" ?>>500px</li>
                <li><input name="source" type="radio" value="Flickr" <?= $source == 'Flickr' ? "checked" : "" ?>>Flickr</li>
                <li><input name="source" type="radio" value="Google" <?= $source == 'Google' ? "checked" : "" ?>>Google</li>
            </ul>
        </div>
        
        <div class="search">
            <h2>Choose your search type.</h2>
            <ul class="unstyled">
                <li><input name="search" type="radio" value="keyword" <?= $search == 'keyword' ? "checked" : "" ?>>Keyword</li>
                <li><input name="search" type="radio" value="string" <?= $search == 'string' ? "checked" : "" ?>>String</li>
            </ul>
        </div>
      
        <div class="sample">
            <input name="term" class="xlarge" placeholder="a word to search with">           
            <div class="sample-image"></div>
        </div>
    
        <div class="actions">
            <div class="left">
                 <button class="btn large getSample" value="sample">Sample</button>
            </div>
            <div class="right">
                <button class="btn large save" value="Save">Save</button>
                <button class="btn large logout" value="logout">Logout</button>
            </div>
        </div>
    </form>
    
</div>

