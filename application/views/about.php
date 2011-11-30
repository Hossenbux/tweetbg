
<div class="about container">
    <h1><?= $title ?></h1>
    <h5>
        “Connect TweetBG to your twitter account to update your twitter profile background image with a collage of photos from 500px.com.”
    </h5>
    <p>
        TweetBG was built during Pixel Hack Day 2011 by <a href="http://adrianmaurer.me" target="_blank">Adrian Maurer</a>, <a href="http://www.vovko.su/" target="_blank">Vladimir Drizhepolov</a>, and <a href="http://akrillo.tumblr.com/" target="_blank">Mike Cirillo</a> and was the third place winner for the event.
    </p>
    <p>
        The application crawls your latest tweets starting at the last position it left off at for any tweet with a word containing an asterix at the end. The app then proceeds to do a search to the 500px API using the keyword to return a set of images that are randomly selected to build an image collage. When completed the application posts the image as your Twitter profile background using the Twitter API.
    </p>
    <p>
        This project is available to be <a href="https://github.com/adrianmaurer/tweetbg" target="_blank">forked on github</a> 
        for any developer who would like to improve the application. After all this was hacked together in one weekend and expanded as quickly as possible
        the following week.
    </p>
    <p>
        We are also hosting this application with amazon and are paying out of out own pockets to keep it operational. So if you like the TweetBG and would like to 
        keep it alive please donate and all proceeds will go to improving the app and keeping the server running.
    </p>
    <p>
        Thank you,<br> <strong>Adrian and Vladimir</strong>.
    </p>
    <form class="unstyled" action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_donations">
        <input type="hidden" name="business" value="adrian.maurer@gmail.com">
        <input type="hidden" name="lc" value="CA">
        <input type="hidden" name="item_name" value="tweetbg">
        <input type="hidden" name="no_note" value="0">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>

</div>