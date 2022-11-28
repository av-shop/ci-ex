<h1>Seleccione su perfil de desarrollo</h1>
<form method="GET">
    <ul>
        <?php foreach($profiles as $profile): ?>
            <li>
                <button name="code" value="<?=htmlspecialchars($profile->sub)?>">
                    <?=htmlspecialchars($profile->name)?> -
                    <?=htmlspecialchars($profile->email)?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
</form>