<h1>Listado de todos los usuarios</h1>

<table>
    <thead>
        <tr>
            <th>NOMBRE</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td>
                    <a href="<?=base_url('/ldap/detalle/' . htmlspecialchars($user->id))?>">
                        <?=htmlspecialchars($user->name)?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<h2>Configuracion de ejemplo</h2>
<pre style="border: solid 1px black">
[directory]
hostname=ldap.forumsys.com
port=389
admindn="cn=read-only-admin,dc=example,dc=com"
password=password
usersdn="dc=example,dc=com"
userid=uid
username=cn
useremail=mail
userphone=telephonenumber
</pre>