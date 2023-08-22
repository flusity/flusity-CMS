<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle rounded-pill navmenubutton" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user-profile">
            <?php echo htmlspecialchars(getUserNameById($db, $prefix, $_SESSION['user_id'])); ?>
            <div class="profile-picture-container">
                <img src="/assets/img/user-profile.png" alt="Profile Picture" class="profile-picture">
            </div>
        </div>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php if ($isAdmin): ?>
            <a class="dropdown-item" href="admin.php"><?php echo t("Dashboard"); ?></a>
        <?php endif; ?>
        <a class="dropdown-item" href="myaccount"><?php echo t("Profile"); ?></a>
        <a class="dropdown-item" href="logout.php"><?php echo t("Sign out"); ?></a>
    </div>
</div>
