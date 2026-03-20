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
        <div class="admin-card">
            <div class="admin-card-body">
                <div class="admin-card-header" style="display:flex; justify-content:space-between; align-items:center;">
					<div class="admin-card-title" style="margin-bottom:0;">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--color-primary);">
							<path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
						</svg>
						Liste des commandes 
						<?php if($idclient > 0) { ?>
							(<a href="index.php?r=mclient&id=<?php echo $idclient; ?>" class="text-primary hover:underline font-medium"><?php echo prenomClient($idclient).' '.nomClient($idclient); ?></a>)
						<?php } ?>
					</div>
					<div>
                        <button class="admin-btn admin-btn-danger delete_all_cmd">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
								<path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
							</svg>
							Supprimer la sélection
						</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <input type="hidden" id="idclient_filter" value="<?php echo $idclient; ?>">
                    <table id="tableCmd" class="admin-table">
                        <thead>
                            <tr>
                                <th ><input type="checkbox" id="checkAllCmd" style="position:relative;left:0;opacity:1"></th>
                                <th >id</th>
                                <th >N° Commande</th>
                                <th >Client</th>
                                <th >Montant</th>
                                <th >Etat</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data populated via DataTables Ajax (arrays_commandes.php) -->
                        </tbody>
                    </table>
                    <?php if($idclient > 0) { ?>
                    <div class="col-md-12 mt-4">
                        <div class="text-right">
                            <a href="index.php?r=clients" class="admin-btn admin-btn-ghost"> Retour à la liste </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ?>

        
