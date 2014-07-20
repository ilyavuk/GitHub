<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function walltoall_strip_bad_words($str,$bdw){
	$bdw = trim($bdw);
	$bdw = preg_replace('/,$/','',$bdw);
	$bdw = explode(",",$bdw);
	$str = str_ireplace($bdw,'...',$str);
	return $str;
}
if ( ! function_exists('user_privilege'))
{
    function user_privilege($var = '')
    {
       switch ($var)
		{
		case 1:
		  return 'R';
		  break;
		case 2:
		  return 'E';
		  break;
		case 3:
		  return 'M';
		  break;
		}
    }   
	
function youtube_segment($raw_url){
		
	  $url_segments = parse_url($raw_url);
	  parse_str($url_segments['query'], $segment);
	  $v = $segment['v'];
	  return 'http://www.youtube.com/embed/'.$v.'?theme=light&amp;color=white';
	  
	}
}
function removeTokens($s){
//	$s = strip_tags($s,'<p><br/>');
//	$s = str_replace(' ','',$s);
    $s = str_replace("'", "", $s);
	$s = preg_replace("/\r\n|\r|\n/", ' ', $s);
	$s = word_limiter($s,100);
	return $s;
}
function descOptimizer($s){
	$s = strip_tags($s);
	$s = character_limiter($s, 20);
	$s = trim($s);
	$s = str_replace("&nbsp;", "", $s);
	return $s;
}
function superSpecCharRemove($s) {
	/*$s= htmlspecialchars_decode(strip_quotes($s)); 
	$s = strip_tags($s);*/
//	$s = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $s);
	$s = word_limiter($s,50);
	$s = json_encode($s);
	$s = strip_html_tags($s);
	$s=str_replace(array('"','/'),'', $s);
	return $s;
}
function strip_html_tags( $text )
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',"$0", "$0", "$0", "$0", "$0", "$0","$0", "$0",), $text );
  
    // you can exclude some html tags here, in this case B and A tags        
    return strip_tags( $text , '<b><a>' );
}