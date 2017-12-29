<?php
require_once('twitteroauth.php');
require_once('Config.php');

$file = '/var/www/html/shitstorm-twitter/cron.log';

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$keywords = array(
	// General keywords
	'astronomy',
	'artificial intelligence',
	'electronics',
	'ethereum',
	'bitcoin',
	'blockchain',
	'diy',
	'androiddev',
	'cryptography',
	'arduino',
	'raspberry pi',
	'kotlin',
	'java',
	'hackernews',
	'react native',
	'rxjava',
	'rxandroid',
	'spacex',
	// Subreddit
	'/r/somebodymakethis',
	'/r/youshouldknow',
	'/r/ethereum',
	'/r/bitcoin',
	'/r/ethtrader',
	'/r/androiddev',
	'/r/kotlin',
	'/r/reactnative',
	'/r/webdev'
);
$rand_key = array_rand($keywords, 1);
$search = $twitter->get('search/tweets', array('q' => $keywords[$rand_key] . '+filter:safe', 'count' => 1, 'lang' => 'en'));

foreach($search->statuses as $tweet) {
   $tweet_id = $tweet->id_str;
   $twitter->post('statuses/retweet/'.$tweet_id);
   echo "<b>Tweet text:</b> ".$tweet->text."<br/>";
}

?>
