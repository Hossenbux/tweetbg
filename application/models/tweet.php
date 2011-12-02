<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twitter extends CI_Model
{
    function __construct() {
        parent::__construct();
        error_reporting (0);
    }
    
    public function cleanTweet($tweet) {
        $this->clearTwitter(&$tweet);
        $this->clearPronouns(&$tweet);
        $this->clearHelping(&$tweet);
        $this->clearPrepositions(&$tweet);
        return $tweet;
    }
    
    public function clearTwitter($tweet) {
        $tweet = preg_replace('/@([A-Za-z0-9_]+)/', '', $tweet);
        $tweet = preg_replace('/#([A-Za-z0-9_]+)/', '', $tweet);
        return $tweet;
    }
    
    private function clearPrepositions($tweet) {
        $tweet = str_replace ( 'abaft' , '' , $tweet);
        $tweet = str_replace ( 'aboard' , '' , $tweet);
        $tweet = str_replace ( 'about' , '' , $tweet);
        $tweet = str_replace ( 'above' , '' , $tweet);
        $tweet = str_replace ( 'absent' , '' , $tweet);
        $tweet = str_replace ( 'across' , '' , $tweet);
        $tweet = str_replace ( 'afore' , '' , $tweet);
        $tweet = str_replace ( 'after' , '' , $tweet);
        $tweet = str_replace ( 'against' , '' , $tweet);
        $tweet = str_replace ( 'along' , '' , $tweet);
        $tweet = str_replace ( 'alongside' , '' , $tweet);
        $tweet = str_replace ( 'amid' , '' , $tweet);
        $tweet = str_replace ( 'amidst' , '' , $tweet);
        $tweet = str_replace ( 'among' , '' , $tweet);
        $tweet = str_replace ( 'amongst' , '' , $tweet);
        $tweet = str_replace ( 'apropos' , '' , $tweet);
        $tweet = str_replace ( 'around' , '' , $tweet);
        $tweet = str_replace ( 'aside' , '' , $tweet);
        $tweet = str_replace ( 'astride' , '' , $tweet);
        $tweet = str_replace ( 'athwart' , '' , $tweet);
        $tweet = str_replace ( 'atop' , '' , $tweet);
        $tweet = str_replace ( 'barring' , '' , $tweet);
        $tweet = str_replace ( 'before' , '' , $tweet);
        $tweet = str_replace ( 'behind' , '' , $tweet);
        $tweet = str_replace ( 'beneath' , '' , $tweet);
        $tweet = str_replace ( 'beside' , '' , $tweet);
        $tweet = str_replace ( 'besides' , '' , $tweet);
        $tweet = str_replace ( 'between' , '' , $tweet);
        $tweet = str_replace ( 'betwixt' , '' , $tweet);
        $tweet = str_replace ( 'beyond' , '' , $tweet);
        $tweet = str_replace ( 'but' , '' , $tweet);
        $tweet = str_replace ( 'circa' , '' , $tweet);
        $tweet = str_replace ( 'concerning' , '' , $tweet);
        $tweet = str_replace ( 'despite' , '' , $tweet);
        $tweet = str_replace ( 'down' , '' , $tweet);
        $tweet = str_replace ( 'during' , '' , $tweet);
        $tweet = str_replace ( 'except' , '' , $tweet);
        $tweet = str_replace ( 'excluding' , '' , $tweet);
        $tweet = str_replace ( 'failing' , '' , $tweet);
        $tweet = str_replace ( 'following' , '' , $tweet);
        $tweet = str_replace ( 'for' , '' , $tweet);
        $tweet = str_replace ( 'from' , '' , $tweet);
        $tweet = str_replace ( 'given' , '' , $tweet);
        $tweet = str_replace ( 'including' , '' , $tweet);
        $tweet = str_replace ( 'inside' , '' , $tweet);
        $tweet = str_replace ( 'into' , '' , $tweet);
        $tweet = str_replace ( 'instead' , '' , $tweet);
        $tweet = str_replace ( 'lest' , '' , $tweet);
        $tweet = str_replace ( 'like' , '' , $tweet);
        $tweet = str_replace ( 'mid' , '' , $tweet);
        $tweet = str_replace ( 'midst' , '' , $tweet);
        $tweet = str_replace ( 'minus' , '' , $tweet);
        $tweet = str_replace ( 'modulo' , '' , $tweet);
        $tweet = str_replace ( 'near' , '' , $tweet);
        $tweet = str_replace ( 'next' , '' , $tweet);
        $tweet = str_replace ( 'notwithstanding' , '' , $tweet);
        $tweet = str_replace ( 'of' , '' , $tweet);
        $tweet = str_replace ( 'off' , '' , $tweet);
        $tweet = str_replace ( 'on' , '' , $tweet);
        $tweet = str_replace ( 'onto' , '' , $tweet);
        $tweet = str_replace ( 'opposite' , '' , $tweet);
        $tweet = str_replace ( 'out' , '' , $tweet);
        $tweet = str_replace ( 'outside' , '' , $tweet);
        $tweet = str_replace ( 'over' , '' , $tweet);
        $tweet = str_replace ( 'pace' , '' , $tweet);
        $tweet = str_replace ( 'past' , '' , $tweet);
        $tweet = str_replace ( 'per' , '' , $tweet);
        $tweet = str_replace ( 'plus' , '' , $tweet);
        $tweet = str_replace ( 'pro' , '' , $tweet);
        $tweet = str_replace ( 'qua' , '' , $tweet);
        $tweet = str_replace ( 'regarding' , '' , $tweet);
        $tweet = str_replace ( 'round' , '' , $tweet);
        $tweet = str_replace ( 'sans' , '' , $tweet);
        $tweet = str_replace ( 'save' , '' , $tweet);
        $tweet = str_replace ( 'since' , '' , $tweet);
        $tweet = str_replace ( 'than' , '' , $tweet);
        $tweet = str_replace ( 'through' , '' , $tweet);
        $tweet = str_replace ( 'thru' , '' , $tweet);
        $tweet = str_replace ( 'throughout' , '' , $tweet);
        $tweet = str_replace ( 'thruout' , '' , $tweet);
        $tweet = str_replace ( 'till' , '' , $tweet);
        $tweet = str_replace ( 'times' , '' , $tweet);
        $tweet = str_replace ( 'toward' , '' , $tweet);
        $tweet = str_replace ( 'towards' , '' , $tweet);
        $tweet = str_replace ( 'under' , '' , $tweet);
        $tweet = str_replace ( 'underneath' , '' , $tweet);
        $tweet = str_replace ( 'unlike' , '' , $tweet);
        $tweet = str_replace ( 'until' , '' , $tweet);
        $tweet = str_replace ( 'upon' , '' , $tweet);
        $tweet = str_replace ( 'versus' , '' , $tweet);
        $tweet = str_replace ( 'via' , '' , $tweet);
        $tweet = str_replace ( 'vice' , '' , $tweet);  
        $tweet = str_replace ( 'with' , '' , $tweet);  
        $tweet = str_replace ( 'within' , '' , $tweet);  
        $tweet = str_replace ( 'without' , '' , $tweet);  
        $tweet = str_replace ( 'worth' , '' , $tweet);  
        $tweet = str_replace ( 'w/' , '' , $tweet);     
        $tweet = str_replace ( 'w/in' , '' , $tweet);  
        $tweet = str_replace ( 'w/i' , '' , $tweet);  
        $tweet = str_replace ( 'w/o' , '' , $tweet);  
        $tweet = str_replace ( 'according to' , '' , $tweet);  
        $tweet = str_replace ( 'ahead of' , '' , $tweet);  
        $tweet = str_replace ( 'apart from' , '' , $tweet);    
        $tweet = str_replace ( 'regards' , '' , $tweet);  
        $tweet = str_replace ( 'back to' , '' , $tweet);  
        $tweet = str_replace ( 'because' , '' , $tweet);  
        $tweet = str_replace ( 'close to' , '' , $tweet);  
        $tweet = str_replace ( 'due to' , '' , $tweet);  
        $tweet = str_replace ( 'owing to' , '' , $tweet);  
        $tweet = str_replace ( 'prior to' , '' , $tweet);  
        $tweet = str_replace ( 'pursuant to' , '' , $tweet);  
        $tweet = str_replace ( 'regardless of' , '' , $tweet);  
        $tweet = str_replace ( 'right of' , '' , $tweet);  
        $tweet = str_replace ( 'left of' , '' , $tweet);  
        $tweet = str_replace ( 'near to' , '' , $tweet);  
        $tweet = str_replace ( 'next to' , '' , $tweet);  
        $tweet = str_replace ( 'subsequent to' , '' , $tweet);  
        $tweet = str_replace ( 'thanks to' , '' , $tweet);  
        $tweet = str_replace ( 'that of' , '' , $tweet);  
        $tweet = str_replace ( 'where as' , '' , $tweet);  
        $tweet = str_replace ( 'as far as' , '' , $tweet);  
        $tweet = str_replace ( 'as well as' , '' , $tweet);  
        $tweet = str_replace ( 'for the sake of' , '' , $tweet);  
        $tweet = str_replace ( 'in accordance with' , '' , $tweet);  
        $tweet = str_replace ( 'in addition to' , '' , $tweet);  
        $tweet = str_replace ( 'in case of' , '' , $tweet);  
        $tweet = str_replace ( 'in front of' , '' , $tweet);  
        $tweet = str_replace ( 'in lieu of' , '' , $tweet);  
        $tweet = str_replace ( 'in order to' , '' , $tweet);  
        $tweet = str_replace ( 'in place of' , '' , $tweet);
        $tweet = str_replace ( 'in point of' , '' , $tweet);  
        $tweet = str_replace ( 'in spite of' , '' , $tweet);  
        $tweet = str_replace ( 'on account of' , '' , $tweet);  
        $tweet = str_replace ( 'on behalf of' , '' , $tweet);  
        $tweet = str_replace ( 'on top of' , '' , $tweet);  
        $tweet = str_replace ( 'with regard to' , '' , $tweet);  
        $tweet = str_replace ( 'with respect to' , '' , $tweet);  
        $tweet = str_replace ( 'concerning' , '' , $tweet);  
        $tweet = str_replace ( 'considering' , '' , $tweet);  
        $tweet = str_replace ( 'regarding' , '' , $tweet);  
        $tweet = str_replace ( 'worth' , '' , $tweet);  
        $tweet = str_replace ( 'apart from' , '' , $tweet);  
        $tweet = str_replace ( 'but' , '' , $tweet);  
        $tweet = str_replace ( 'except' , '' , $tweet); 
        $tweet = str_replace ( 'save' , '' , $tweet);  
        $tweet = str_replace ( 'plus' , '' , $tweet);   
        return $tweet;
    }
    
    private function clearPronouns($tweet) {
        preg_replace('/\s+\S{1,2}(?!\S)|(?<!\S)\S{1,2}\s+/', '', $tweet)
        $tweet = str_replace ( 'him' , '' , $tweet); 
        $tweet = str_replace ( 'myself' , '' , $tweet);  
        $tweet = str_replace ( 'mine' , '' , $tweet); 
        $tweet = str_replace ( 'ourselves' , '' , $tweet); 
        $tweet = str_replace ( 'ourself' , '' , $tweet); 
        $tweet = str_replace ( 'you' , '' , $tweet);
        $tweet = str_replace ( 'your' , '' , $tweet);
        $tweet = str_replace ( 'yourself' , '' , $tweet);
        $tweet = str_replace ( 'yours' , '' , $tweet); 
        $tweet = str_replace ( 'you all' , '' , $tweet);
        $tweet = str_replace ( 'ye' , '' , $tweet); 
        $tweet = str_replace ( 'y\'all\'s' , '' , $tweet);
        $tweet = str_replace ( 'y\'all' , '' , $tweet);   
        $tweet = str_replace ( 'youse' , '' , $tweet);
        $tweet = str_replace ( 'himself' , '' , $tweet); 
        $tweet = str_replace ( 'herself' , '' , $tweet);
        $tweet = str_replace ( 'itself' , '' , $tweet); 
        $tweet = str_replace ( 'one' , '' , $tweet);
        $tweet = str_replace ( 'its' , '' , $tweet); 
        $tweet = str_replace ( 'onself' , '' , $tweet);
        $tweet = str_replace ( 'they' , '' , $tweet); 
        $tweet = str_replace ( 'them' , '' , $tweet);
        $tweet = str_replace ( 'themself' , '' , $tweet); 
        $tweet = str_replace ( 'themselves' , '' , $tweet);
        $tweet = str_replace ( 'theirs' , '' , $tweet); 
        return $tweet;
    }
    
    private function clearHelping($tweet) {
        $tweet = str_replace ( 'were' , '' , $tweet);
        $tweet = str_replace ( 'are' , '' , $tweet); 
        $tweet = str_replace ( 'being' , '' , $tweet);
        $tweet = str_replace ( 'been' , '' , $tweet);
        $tweet = str_replace ( 'have' , '' , $tweet);
        $tweet = str_replace ( 'has' , '' , $tweet); 
        $tweet = str_replace ( 'had' , '' , $tweet);
        $tweet = str_replace ( 'does' , '' , $tweet);  
        $tweet = str_replace ( 'did' , '' , $tweet);
        $tweet = str_replace ( 'can' , '' , $tweet); 
        $tweet = str_replace ( 'could' , '' , $tweet);
        $tweet = str_replace ( 'may' , '' , $tweet); 
        $tweet = str_replace ( 'might' , '' , $tweet);
        $tweet = str_replace ( 'must' , '' , $tweet); 
        $tweet = str_replace ( 'will' , '' , $tweet);
        $tweet = str_replace ( 'should' , '' , $tweet); 
        $tweet = str_replace ( 'would' , '' , $tweet);
        $tweet = str_replace ( 'ought to' , '' , $tweet); 
        $tweet = str_replace ( 'used to' , '' , $tweet);
        return $tweet;
    }
}