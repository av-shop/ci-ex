<h1>Alta de categoria</h1>
<form method="post" action="<?=base_url('/abm/actualizar/')?>">
    <input type="hidden" name="id" value="<?=$categoria->id?>" />
    <input type="text" maxlength="45" placeholder="nombre" name="nombre" value="<?=$categoria->nombre?>"/>
    <input type="text" maxlength="6" placeholder="color" name="color" value="<?=$categoria->color?>"/>
    <input type="text" maxlength="6" placeholder="fondo" name="fondo" value="<?=$categoria->fondo?>"/>
    <input type="submit"/>
</form>