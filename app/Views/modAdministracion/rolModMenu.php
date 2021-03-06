<?= $this->extend('template/admin_template') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Configuración de Rol-Módulo-Menú</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button type="button" class="btn btn-outline-success mb-2" data-toggle="modal"
                    data-target="#agregarModal"><i class="fa fa-plus"></i> Agregar Rol-Módulo-Menu</button>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <div id="datatable_wrapper" class="dataTables_wrapper container-fluid no-footer">
                                <div class="row">
                                    <div class="col-sm-12" id="lista"><br>
                                        <table id="datatable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>ROL/MÓDULO/MENÚ</th>
                                                    <th>ADMIN MENÚ</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($datos as $key) : ?>
                                                <tr role="row" class="odd">
                                                    <td><?= $key->id ?></td>
                                                    <td><?= $key->rol ?>/<?= $key->modulo ?>/<?= $key->menu ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary btn-sm btn-edit"
                                                            data-id="<?= $key->id ?>" data-r="<?= $key->rolId ?>"
                                                            data-rol="<?= $key->rol ?>" data-mod="<?= $key->moduloId ?>"
                                                            data-modulo="<?= $key->modulo ?>"><i class="fa fa-plus"></i>
                                                            Agregar Menú</a>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-warning btn-sm btn-editRMM"
                                                            data-id="<?php echo $key->id ?>"
                                                            data-nombremod="<?php echo $key->modulo ?>"
                                                            data-moduloid="<?php echo $key->moduloId ?>"
                                                            data-menuid="<?php echo $key->menuId ?>"><i
                                                                class="fa fa-pencil-square-o"></i> Editar</a>
                                                        <a href="#" class="btn btn-danger btn-sm btn-deleteRMM"
                                                            data-id="<?php echo $key->id ?>"
                                                            data-nombremod="<?php echo $key->modulo ?>"
                                                            data-moduloid="<?php echo $key->moduloId ?>"
                                                            data-menuid="<?php echo $key->menuId ?>"><i
                                                                class="fa fa-trash"></i> Eliminar</a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Agregar Módulo-->
<form action="<?php echo base_url() . '/crearRMM' ?>" method="POST">
    <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar un nuevo Módulo/Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Seleccionar Rol:</label>
                        <select name="rolId" required="required" class="form-control">
                            <option value="">-Selecciona un Rol-</option>
                            <?php foreach ($rol as $key) : ?>
                            <option value="<?php echo $key->rolId ?>"><?php echo $key->nombreRol ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Selecciona el Modulo-Menu:</label>
                        <select name="moduloMenuId" required="required" class="form-control">
                            <option value="">-Selecciona un Modulo-Menu-</option>
                            <?php foreach ($ModuloM as $key) : ?>
                            <option value="<?php echo $key->moduloMenuId ?>">
                                <?php echo $key->Modulo ?>/<?php echo $key->Menu ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Agregar Módulo-->

<div class="container x_panel" id="formulario" style="display: none">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <form action="<?php echo base_url() . '/editRol' ?>" method="POST">
                <input type="hidden" name="rolModuloMenuId" class="rolModuloMenuId">

                <!--<div class="form-group">
                                <label>Rol: <b><i id="nomRol"></i></b></label>
                            </div>-->

                <div class="form-group">
                    <input type="hidden" name="rolId" class="roli">
                </div>

                <div class="form-group">
                    <label>Listado de menús en <b><i id="nomModulo"></i></b></label><br><br>
                    <div id="menuId" name="menus[]">

                    </div>
                </div>
                <br>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Agregar</button>
                </div>
            </form>

        </div>
        <div class="col-md-4">
            <label>Menús que posee <b><i id="nRol"></i></b> :</label>
            <br><br>
            <table id="datatable" class="display " style="width: 100%;" role="grid">
                <tbody id="rolMenu">
                    <tr role="row">

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <a href="<?= base_url() . route_to('rolModMenu') ?>" class="btn btn-outline-secondary mb-2"><i
            class="fa fa-angle-double-left"></i> Volver</a>

</div>

<!-- Modal Delete Rol-->
<form action="<?php echo base_url() . '/eliminarR' ?>" method="POST">
    <div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Rol-Módulo-Menú</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h4>¿Esta seguro que desea eliminarlo? <b><i class="moduloMenuId"></i></b></h4>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="rolModuloMenuId" class="rolModuloMenuId">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">SI</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Delete RolModuloMenu-->

<!-- Modal Edit RolModuloMenu-->
<form action="<?php echo base_url() . '/actualizarRMM' ?>" method="POST">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Rol-Módulo-Menú</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Seleccionar Rol:</label>
                        <select name="rolId" id="rolId" required="required" class="form-control rolId">
                            <option value="">-Selecciona un Rol-</option>
                            <?php foreach ($rol as $key) : ?>
                            <option value="<?php echo $key->rolId ?>"><?php echo $key->nombreRol ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Selecciona el Modulo-Menu:</label>
                        <select name="moduloMenuId" id="moduloMenuId" required="required"
                            class="form-control moduloMenuId">
                            <option value="">-Selecciona un Modulo-Menu-</option>
                            <?php foreach ($ModuloM as $key) : ?>
                            <option value="<?php echo $key->moduloMenuId ?>">
                                <?php echo $key->Modulo ?>/<?php echo $key->Menu ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">

                    <input type="hidden" name="rolModuloMenuId" class="rolModuloMenuId">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Modal Edit Módulo-->


<script src="vendors/jquery/dist/jquery.slim.min.js"></script>
<script src="vendors/popper/umd/popper.min.js"></script>
<script src="vendors/jquery/dist/jquery.min.js"></script>

<script type="text/javascript">
let mensaje = '<?php echo $mensaje ?>';

if (mensaje == '1') {
    swal('', 'Agregado', 'success');
} else if (mensaje == '2') {
    swal('', 'No se elimino', 'error');
} else if (mensaje == '3') {
    swal('', 'Eliminado', 'success');
} else if (mensaje == '4') {
    swal('', 'Se ha actualizado correctamente', 'success');
} else if (mensaje == '5') {
    swal('', 'No se actualizo', 'error');
}
</script>

<script>
$(document).ready(function() {

    // get Edit Product
    $('.btn-editRMM').on('click', function() {
        // get data from button edit
        const id = $(this).data('id');
        const rolId = $(this).data('rol');
        const moduloMenuId = $(this).data('modulomenuid');

        // Set data to Form Edit
        $('.rolModuloMenuId').val(id);
        $('.rolId').val(rolId);
        $('.moduloMenuId').val(moduloMenuId);

        // Call Modal Edit
        $('#editModal').modal('show');
    });

    // get Delete Product
    $('.btn-deleteRMM').on('click', function() {
        // get data from button edit
        const id = $(this).data('id');
        const rolId = $(this).data('rol');
        const moduloMenuId = $(this).data('modulomenuid');

        // Set data to Form Edit
        $('.rolModuloMenuId').val(id);
        $('moduloMenuId').html();
        // Call Modal Edit
        $('#eliminarModal').modal('show');
    });

});
</script>
<script>
$(document).ready(function() {
    //$('#formulario').css("display", "none");
    // get Edit Product
    $('.btn-edit').on('click', function() {
        // get data from button edit
        var id = $(this).data('id');
        var moduloId = $(this).data('mod');
        var rolId = $(this).data('r');
        var rol = $(this).data('rol');
        var modulo = $(this).data('modulo');

        $('.roli').val(rolId);
        $('#nomRol').html(rol);
        $('#nRol').html(rol);
        $('#nomModulo').html(modulo);

        var menus = $("#menuId");
        var roles = $("#rolMenu");

        $.ajax({
            type: "GET",
            url: "<?= base_url() . route_to('editRolMM') ?>",
            data: {
                moduloId: moduloId
            },
            success: function(data) {
                //alert(data);
                var dataObj = JSON.parse(data);

                $.each(dataObj, function(index, val) {
                    menus.append("<div class='form-check'>" +
                        "<input class='form-check-input' type='checkbox' name='menu[]' value='" +
                        val.idM + "'>" +
                        "<label class='form-check-label'>" + val.nomMenu +
                        "</label></div>")
                });

                //window.location.href="<= base_url().route_to('editarRolModMenu'); ?>";
            }
        });

        $.ajax({
            type: "GET",
            url: "<?= base_url() . route_to('menuList') ?>",
            data: {
                rolId: rolId
            },
            success: function(data) {

                var dataObj = JSON.parse(data);

                $.each(dataObj, function(index, val) {
                    roles.append('<tr><td id="la">' + val.menu + '</td>' +
                        '<td><button href="#" onclick="eliminar(' + val.id +
                        ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td></tr>'
                        )

                });
            }
        });

        $('#formulario').css("color", "#010806");
        $('#formulario').css("font-size", 14);

        $('#formulario').css("display", "block");
        $('#lista').hide();

    });


});

function eliminar(idEliminar) {
    $('.rolModuloMenuId').val(idEliminar);
    $('.menuM').html(idEliminar);
    // Call Modal Eliminar
    $('#eliminarModal').modal('show');

}
</script>


<script>
$(document).ready(function() {
    $('#datatable').DataTable({
        language: {
            url: 'vendors/datatables.net/es.json'
        }
    });
});
</script>

<?= $this->endSection() ?>