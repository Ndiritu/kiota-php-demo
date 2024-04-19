<?php

use League\Uri\Uri;
use League\Uri\UriTemplate;

// Ensures imported classes can be found
set_include_path(__DIR__);
require '../vendor/autoload.php';

$uri = new UriTemplate("{+baseurl}/groups{?%24top,%24skip,%24search,%24filter,%24count,%24orderby,%24select,%24expand}");

echo $uri->expand([
    'baseurl' => 'https://graph.microsoft.com',
    '%24count' => "true"
]);