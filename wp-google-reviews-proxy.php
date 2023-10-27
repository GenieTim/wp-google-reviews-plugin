<?php
// header('Content-type: text/css');

$_ENV['BASE_URL'] = getenv('BASE_URL');

if (!isset($_ENV['BASE_URL'])) {
  throw new Exception('ENV "BASE_URL" missing.');
}

if (!isset($_GET['url'])) {
  die('nope...');
}

$url = $_GET['url'];

if (!is_dir('./cache')) {
  mkdir('./cache');
}

$url = str_replace('http://', 'https://', $url);
$url = base64_encode($url);

getFile($url);

function getFile($url)
{
  $filename = md5($url) . '.cache';
  if (!file_exists('./cache/' . $filename)) {
    cacheFile($url, './cache/' . $filename);
  }

  echo file_get_contents('./cache/' . $filename);
}

function getHost($Address)
{
  $parseUrl = parse_url(trim($Address));
  return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2)));
}

function getThisUrl()
{
  if (function_exists('plugins_url')) {
    return plugins_url('wp-google-reviews-proxy.php', dirname(__FILE__));
  }
  return $_ENV['BASE_URL'] . '/wp-content/plugins/wp-google-reviews/wp-google-reviews-proxy.php';
}

function cacheFile($url, $filepath)
{
  $url = base64_decode($url);
  $url = str_replace('http://', 'https://', $url);
  $url = str_replace(' ', '+', $url);
  if (in_array(getHost($url), [
    'lh3.googleusercontent.com', 'googleusercontent.com', 'maps.gstatic.com',
    'fonts.googleapis.com', 'fonts.gstatic.com', 'www.gstatic.com', 'themes.googleusercontent.com'
  ])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $content = str_replace('https://', getThisUrl() . '?url=https://', $result);

    file_put_contents($filepath, $content);
  } else {
    die('invalid: ' . $url);
  }
}
