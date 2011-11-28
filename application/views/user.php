<div class="settings container">
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
            <div class="sample-image"></div>
        </div>
    
        <div class="actions">
            <div class="left">
                 <button class="btn large getSample" value="sample">Sample</button>
            </div>
            <div class="right">
                <button class="btn large" type="submit" value="Save">Save</button>
                <button class="btn large logout" value="logout">Logout</button>
            </div>
        </div>
    </form>
    
</div>

