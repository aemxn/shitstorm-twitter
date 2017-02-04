<?php
// Include twitteroauth
require_once('twitteroauth.php');
//require_once('Logging.php');
require_once('Config.php');

//$log = new Logging();
$file = '/var/www/html/shitstorm-twitter/cron.log';
//$log->lfile($file);

$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

/**
 * Search tweets
 * https://dev.twitter.com/rest/reference/get/search/tweets
 * q: search query
 * count: The number of tweets to return per page, up to a maximum of 100. Defaults to 15.
 */
$keywords = array(
	// General keywords
	'astronomy',
	'science',
	'space',
	'virtual reality',
	'augmented reality',
	'artificial intelligence',
	'electronics',
	'decentralized',
	'ethereum',
	'bitcoin',
	'blockchain',
	'diy',
	'programming',
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
	'sunvox',
	// Subreddit
	'/r/somebodymakethis',
	'/r/youshouldknow',
	'/r/ethereum',
	'/r/bitcoin',
	'/r/ethtrader',
	'/r/androiddev',
	'/r/kotlin',
	'/r/reactnative',
	'/r/webdev',
	// Market analysis (cryptocurrency)
	'#ethusd',
	'$btc'
);
$rand_key = array_rand($keywords, 1);
$search = $twitter->get('search/tweets', array('q' => $keywords[$rand_key], 'count' => 1));

foreach($search->statuses as $tweet) {
	/**
	 * Retweet a status
	 * https://dev.twitter.com/rest/reference/post/statuses/retweet/%3Aid
	 * $tweet_id: The numerical ID of the desired status.
	 */
	$tweet_id = $tweet->id_str;
	$twitter->post('statuses/retweet/'.$tweet_id);
	echo "<b>Tweet text:</b> ".$tweet->text."<br/>";
//	$log->lwrite("Type: tweet, Text: ".trim($tweet->text));

	/**
	 * Follow a tweethandle
	 * https://dev.twitter.com/rest/reference/post/friendships/create
	 * $screen_name: The screen name of the user for whom to befriend.
	 * $follow: Enable notifications for the target user.
	*/
	// if (strpos(strtolower($tweet->text),'follow') !== false) {
//		$screen_name = $tweet->user->screen_name;
//		$twitter->post('friendships/create', array('screen_name' => $screen_name, 'follow' => false));
//		echo "<b>Screen name:</b> ".$tweet->user->screen_name."<br/>";
//		$log->lwrite("Type: Username, Name: ".$tweet->user->screen_name);
	// }

	/**
	 * Post a Tweet
	 * https://dev.twitter.com/rest/reference/post/statuses/update
	 * $status: The text of your status update, typically up to 140 characters.
	 */
	// $status = 'RT @'.$tweet->user->screen_name.' '.$tweet->text;
	// if(strlen($status) > 140)
	// 	$status = substr($status, 0, 139);
	// $twitter->post('statuses/update', array('status' => $status));
	// echo $tweet->text."<br/>";
}
//$log->lclose();

?>
