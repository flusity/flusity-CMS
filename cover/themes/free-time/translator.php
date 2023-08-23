<?php

$selected_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $lang_code;

$translations_it = array(
    'contact_us' => 'Susisiekite su mumis',
    'interesting_theme' => 'Dominanti tema',
    'your_email' => 'Jūsų el. paštas',
    'message' => 'Žinutė',
    'human_check' => 'Patikrinama ar esate žmogus',
    'drag_answer' => 'Tempkite atsakymą čia',
    'send' => 'Siųsti',
    'dashboard' => 'Prietaisų skydelis',
    'profile' => 'Profilis',
    'signout' => 'Atsijungti',
    '404_tropic'=> 'Jūs nuklydote į tropinę nežinią! Nieko jūs čia nepamatysite.',
    '404_return_home'=>'Spustelėkite <a href="/">čia</a>, kad grįžtumėte į pagrindinį puslapį.'
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