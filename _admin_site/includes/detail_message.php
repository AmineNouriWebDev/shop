<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
 <div class="row">
 <?php 
 $id=sanitize($_GET['id']);
 ?>
   <?php 
	 $requete = 'SELECT * FROM `messages` WHERE `id`="'.$id.'"';
     $resultat = executeRequete($requete);
	  $data = mysqli_fetch_array($resultat);
								         ?>
                    <div class="col-md-12">
                        <div class="card card-body">
                           <h4 class="card-title">Messages</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-muted m-l-30"><strong>Date contact: </strong> <?php echo timestamptodate(afficheChamp($data['date']));?></p>
                                    <p class="text-muted m-l-30"><strong>Nom contact: </strong> <?php echo afficheChamp($data['nom']);?></p>
                                    <p class="text-muted m-l-30"><strong>Téléphone contact: </strong> <?php echo afficheChamp($data['tel']);?></p>
                                    <p class="text-muted m-l-30"><strong>Email contact: </strong> <?php echo afficheChamp($data['email']);?></p>
                                    <p class="text-muted m-l-30"><strong>Sujet: </strong> <?php echo afficheChamp($data['sujet']);?></p>
                                    <p class="text-muted m-l-30"><strong>Message: </strong> <?php echo afficheChamp($data['contenu']);?></p>
                                </div>
                                <div class="col-md-12">
                                 <div class="text-right">
                                        <a href="index.php?r=messages" class="btn btn-info"> Retour à la liste </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>