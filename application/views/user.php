<div class="settings container">
    <h1>Hello <?= $screen_name ?>,</h1>
    
    <div class="source">
        <ul class="unstyled">
            <li><input name="source" type="radio" value="500px" <?= $source == '500px' ? "checked" : "" ?>>500px</li>
            <li><input name="source" type="radio" value="Flickr" <?= $source == 'Flickr' ? "checked" : "" ?>>Flickr</li>
            <li><input name="source" type="radio" value="Google" <?= $source == 'Google' ? "checked" : "" ?>>Google</li>
        </ul>
    </div>
    
    <div class="search">
        <ul class="unstyled">
            <li><input name="source" type="radio" value="keyword" <?= $search == 'keyword' ? "checked" : "" ?>>Keyword</li>
            <li><input name="source" type="radio" value="string" <?= $search == 'string' ? "checked" : "" ?>>String</li>
        </ul>
    </div>
    
    <div class="sample">
        <button class="btn large getSample" value="sample">Sample</button>
    </div>
    
</div>

