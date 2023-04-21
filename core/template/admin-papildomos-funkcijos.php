<?php
if (isset($_POST['add_post'])) {
    // Gavome naujienos duomenis iš formos
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    
    // Patikriname, ar visi laukai užpildyti
    if (empty($title) || empty($content) || empty($category_id)) {
        // Jei trūksta duomenų, išvedame klaidą
        $error = "Visi laukai turi būti užpildyti!";
    } else {
        // Pridedame naują naujieną į duomenų bazę
        addPost($db, $title, $content, $category_id);
        
        // Nukreipiame vartotoją į naujienų sąrašo puslapį
        header("Location: admin.php");
        exit();
    }
}





if (isset($_POST['edit_post'])) {
    // Gavome naujienos duomenis iš formos
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    
    // Patikriname, ar visi laukai užpildyti
    if (empty($title) || empty($content) || empty($category_id)) {
        // Jei trūksta duomenų, išvedame klaidą
        $error = "Visi laukai turi būti užpildyti!";
    } else {
        // Redaguojame naujieną duomenų bazėje
        editPost($db, $post_id, $title, $content, $category_id);
        
        // Nukreipiame vartotoją į naujienų sąrašo puslapį
        header("Location: admin.php");
        exit();
    }
}


if (isset($_GET['delete_post'])) {
    $post_id = $_GET['delete_post'];
    
    // Ištriname naujieną iš duomenų bazės
    deletePost($db, $post_id);
    
    // Nukreipiame vartotoją į naujienų sąrašo puslapį
    header("Location: admin.php");
    exit();
}



if (isset($_POST['add_category'])) {
    // Gavome kategorijos pavadinimą iš formos
    $name = $_POST['name'];
    
    // Patikriname, ar visi laukai užpildyti
    if (empty($name)) {
        // Jei trūksta duomenų, išvedame klaidą
        $error = "Visi laukai turi būti užpildyti!";
    } else {
        // Pridedame naują kategoriją į duomenų bazę
        addCategory($db, $name);
        
        // Nukreipiame vartotoją į kategorijų sąrašo puslapį
        header("Location: categories.php");
        exit();
    }
}




if (isset($_POST['add_category_to_post'])) {
    // Gavome naujienos ID ir kategorijos ID iš formos
    $post_id = $_POST['post_id'];
    $category_id = $_POST['category_id'];
    
    // Priskiriame naujieną kategorijai
    addPostToCategory($db, $post_id, $category_id);
    
    // Nukreipiame vartotoją į naujienų sąrašo puslapį
    header("Location: admin.php");
    exit();
}



if (isset($_POST['add_menu'])) {
    // Gavome meniu pavadinimą iš formos
    $name = $_POST['name'];
    
    // Patikriname, ar visi laukai užpildyti
    if (empty($name)) {
        // Jei trūksta duomenų, išvedame klaidą
        $error = "Visi laukai turi būti užpildyti!";
    } else {
        // Pridedame naują meniu į duomenų bazę
        addMenu($db, $name);
        
        // Nukreipiame vartotoją į meniu sąrašo puslapį
        header("Location: menus.php");
        exit();
    }
}

if (isset($_POST['add_post_to_menu'])) {
    // Gavome meniu ID ir naujienų ID iš formos
    $menu_id = $_POST['menu_id'];
    $post_ids = $_POST['post_ids'];
    
    // Priskiriame naujienas meniu
    addPostsToMenu($db, $menu_id, $post_ids);
    
    // Nukreipiame vartotoją į meniu redagavimo puslapį
   
    header("Location: edit_menu.php?id={$menu_id}");
    exit();
}

if (isset($_POST['move_posts_to_menu'])) {
    // Gavome meniu ID ir naujienų ID iš formos
    $menu_id = $_POST['menu_id'];
    $post_ids = $_POST['post_ids'];
    
    // Perkeliame naujienas į kitą meniu
    movePostsToMenu($db, $menu_id, $post_ids);
    
    // Nukreipiame vartotoją į meniu redagavimo puslapį
    header("Location: edit_menu.php?id={$menu_id}");
    exit();
}


if (isset($_GET['delete_menu'])) {
    $menu_id = $_GET['delete_menu'];
    
    // Ištriname meniu iš duomenų bazės
    deleteMenu($db, $menu_id);
    
    // Nukreipiame vartotoją į meniu sąrašo puslapį
    header("Location: menus.php");
    exit();
}


if (isset($_GET['delete_menu_posts'])) {
    // Gavome meniu ID ir naujienų ID iš URL
    $menu_id = $_GET['id'];
    $post_id = $_GET['delete_menu_posts'];
    
    // Ištriname naujienos priskyrimą meniui
    deleteMenuPost($db, $menu_id, $post_id);
    
    // Nukreipiame vartotoją į meniu redagavimo puslapį
    header("Location: edit_menu.php?id={$menu_id}");
    exit();
}

if (isset($_POST['edit_menu_name'])) {
    // Gavome meniu ID ir pavadinimą iš formos
    $menu_id = $_POST['menu_id'];
    $name = $_POST['name'];
    
    // Patikriname, ar visi laukai užpildyti
    if (empty($name)) {
        // Jei trūksta duomenų, išvedame klaidą
        $error = "Visi laukai turi būti užpildyti!";
    } else {
        // Redaguojame meniu pavadinimą duomenų bazėje
        editMenuName($db, $menu_id, $name);
        
        // Nukreipiame vartotoją į meniu redagavimo puslapį
        header("Location: edit_menu.php?id={$menu_id}");
        exit();
    }
}

?>
testas