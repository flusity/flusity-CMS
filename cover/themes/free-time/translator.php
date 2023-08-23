<?php

$selected_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $lang_code;

$translations_it = array(
    'contact_us' => 'Contattaci',
     'interesting_theme' => 'Tema interessante',
     'your_email' => 'La tua email posta',
     'message' => 'Messaggio',
     'human_check' => 'Verifica se sei umano',
     'drag_answer' => 'Trascina la risposta qui',
     'send' => 'Invia',
     'dashboard' => 'cruscotto',
     'profile' => 'Profilo',
     'signout' => 'Esci',
     '404_tropic'=> 'Hai vagato nell\'ignoto tropicale! Non vedrai nulla qui.',
     '404_return_home'=>'Fai clic <a href="/">qui</a> per tornare alla home page.'
);

$translations_en = array(
    'contact_us' => 'Contact Us',
    'interesting_theme' => 'Interesting Theme',
    'your_email' => 'Your Email',
    'message' => 'Message',
    'human_check' => 'Human Check',
    'drag_answer' => 'drag the answer here',
    'send' => 'Send',
    'dashboard' => 'Dashboard',
    'profile' => 'Profile',
    'signout' => 'Sign out',
    '404_tropic'=> 'You\'ve wandered off into tropical limbo! You won\'t see anything here.',
    '404_return_home'=>'Click <a href="/">here</a>, to return back home page.'
);

$translations = ($selected_lang == 'it') ? $translations_it : $translations_en;
?>