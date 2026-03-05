<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
<?php 
if (isset($_GET['action']) && $_GET['action'] == 'supp' ) {
?>
    <script language="javascript">
        window.location = 'index.php?r=commandes';
    </script>
<?php 
} 

if (isset($_POST['action_cmd'])) {
    if ($_POST['action_cmd'] == 'supp_multiple' && isset($_POST['ids'])) {
        supprimerCommandesMultiples($_POST['ids']);
        exit;
    }
}

$idclient = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4>Liste des commandes 
                            <?php if($idclient > 0) { ?>
                                (<a href="index.php?r=mclient&id=<?php echo $idclient; ?>" style="text-decoration:underline;"><?php echo prenomClient($idclient).' '.nomClient($idclient); ?></a>)
                            <?php } ?>
                        </h4>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-danger delete_all_cmd"><i class="fa fa-trash text-white"></i> Supprimer la sélection</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <input type="hidden" id="idclient_filter" value="<?php echo $idclient; ?>">
                    <table id="tableCmd" class="table table-bordered table-striped color-table info-table">
                        <thead>
                            <tr>
                                <th style="background-color: #1976d2; text-align:center; width: 40px;"><input type="checkbox" id="checkAllCmd" style="position:relative;left:0;opacity:1"></th>
                                <th style="background-color: #1976d2;">id</th>
                                <th style="background-color: #1976d2;">N° Commande</th>
                                <th style="background-color: #1976d2;">Client</th>
                                <th style="background-color: #1976d2;">Montant</th>
                                <th style="background-color: #1976d2;">Etat</th>
                                <th style="background-color: #1976d2; width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data populated via DataTables Ajax (arrays_commandes.php) -->
                        </tbody>
                    </table>
                    <?php if($idclient > 0) { ?>
                    <div class="col-md-12 mt-4">
                        <div class="text-right">
                            <a href="index.php?r=clients" class="btn btn-info"> Retour à la liste </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ?>

        