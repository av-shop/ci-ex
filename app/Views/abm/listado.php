<h1>Categorias</h1>
<a href="<?=base_url("/abm/alta")?>">Nueva Categoria</a>
<?php if($categorias): ?>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Color</th>
                <th>Fondo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categorias as $categoria): ?>
                <tr>
                    <td><?=$categoria->nombre?></td>
                    <td><?=$categoria->color?></td>
                    <td><?=$categoria->fondo?></td>
                    <td>
                        <a href="<?=base_url('/abm/eliminar/'.$categoria->id)?>">Eliminar</a>
                        <a href="<?=base_url('/abm/editar/'.$categoria->id)?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay categorias</p>
<?php endif; ?>