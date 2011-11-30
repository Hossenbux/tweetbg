
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
        <p><strong>Oh hai der!</strong> Thank you for using our application. We are currently developing the app further to me more dynamic and customizable. Your background will be updated approximately every 5 minutes. Enjoy!.</p>
        <div class="alert-actions">
          <button class="btn small more">Learn more</button> <button class="btn small fadeout">Close</button>
        </div>
    </div>
    
    <img src="<?= $avatar ?>">
    <h1>Hello <?= $screen_name ?>,</h1>
    
    
    <form name="options" method="PUT" action="user">
        <div class="source">
            <h2>Choose your photo source.</h2>
            <div class="alert-message block-message info">
                <a class="fadeout close" href="#">×</a>
                <p class="source-description"><strong>Recommended!</strong><br> 500px is a photographic community powered by creative people from all over the world that lets you share and discover inspiring photographs.</p>
            </div>
            <ul class="unstyled">
                <li><input name="source" type="radio" value="500px" <?= $source == '500px' ? "checked" : "" ?>>500px</li>
                <li><input name="source" type="radio" value="Flickr" <?= $source == 'Flickr' ? "checked" : "" ?>>Flickr</li>
                <li><input name="source" type="radio" value="Google" <?= $source == 'Google' ? "checked" : "" ?>>Google</li>
            </ul>
        </div>
        
        <div class="search">
            <h2>Choose your search type.</h2>
            <div class="alert-message block-message info">
                <a class="fadeout close" href="#">×</a>
                <p class="search-description"><strong>Keyword</strong><br> searches your latest tweet for words containing an asterix(*) at the end and creates a collage of photos based on search results using that word.</p>
            </div>
            <ul class="unstyled">
                <li><input name="search" type="radio" value="keyword" <?= $search == 'keyword' ? "checked" : "" ?>>Keyword</li>
                <li><input name="search" type="radio" disabled="true" value="string" <?= $search == 'string' ? "checked" : "" ?>>String (coming soon)</li>
            </ul>
        </div>
      
        <div class="sample">
            <input name="term" class="xlarge" placeholder="coffee">           
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

