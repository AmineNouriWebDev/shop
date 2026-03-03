
		<section class="section section-content bg-part p-5 mb-5">
		
				<div class="u-shape-1" ></div>
				<div class="container">
					<div class="row align-items-centerrow align-items-center ">
					
						<div class="col-md-4 col-sm-12 u-valign-top">

							<form method="post" action="" data-toggle="validator" role="form" class="contact-form" enctype="multipart/form-data">
							
							    <?php
								$succes = ""; // Initialize variable to prevent undefined warning

                                if(isset($_POST['action']) && $_POST['action']=="send"){
                                    require('recaptcha.php');
                                    $captcha = new Recaptcha('6LffOvAoAAAAAKp9qkH1D111y3Aycr3y9oyfl1LT');
                                    if($captcha->isValid($_POST['g-recaptcha-response'])== false){
                                ?>
                                <script>
                                    alert('Le captcha ne semble pas valide !');
                                    window.history.back();
                                </script>
                                <?php
                                                            
                                    } else {
									
									$nom=sanitize($_POST['name']);
									$email=sanitize($_POST['email']);
									$sujet=sanitize($_POST['sujet']);
									$message=sanitize($_POST['message']);
									$date_creation=time();
						
									$requete1 = 'INSERT INTO `messages` (`nom`, `email`, `sujet`,`contenu`, `date`) VALUES ("'.$nom.'", "'.$email.'", "'.$sujet.'", "'.$message.'","'. $date_creation .'")';
									$resultat = executeRequete($requete1);
						
									//alerte admins    
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
									$headers .= 'From:'.$nomSite.' <no_reply@technoplus.tn>' . "\r\n";
									//$sujet ="Nouveau message envoyé depuis le site";
									
									$template_mail='<table id="mc-template" style="width: 100%; background: #ccc; padding: 10px;" border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td style="width: 100%; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
																	<table style="width: 600px; margin-right: auto; margin-left: auto; background: white; padding: 10px;" border="0" cellspacing="0" cellpadding="0" align="center">
																		<tbody>
																			<tr>
																				<!--Main content container-->
																				<td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
																					<table border="0" cellspacing="0" cellpadding="0">
																						<tbody>
																							<tr>
																								<!--Logo container -->
																								<td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; padding-bottom: 10px; padding-top:10px; text-align:center; vertical-align: top;" valign="top"><img src="media/site/'.$logo.' alt="" /></td>
																							</tr>
																							<tr>
																								<!-- Personal info container -->
																								<td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; vertical-align: top; width: 100%;" valign="top">
																								<p>
																								<p>Bonjour,</p>
																								<p> '.$nom.' vient de vous envoyer un message à partir du site de MOTAATV. </p>
																								<hr /> 
																								<p>Sujet: '.$sujet.'.</p>
																								<p>Message: '.$message.'.</p>';
																								if($email != "") { $template_mail  .= '<p>Ce message est adress  partir de l\'Email: '.$email.'.</p>'; }
																								$template_mail  .= '<hr />
																								<p>A très bientôt.</p>
																							  </td>
																							</tr>
																							<tr>
																								<!-- Org Info -->
																								<td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; padding-top: 10px;">
																									<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
																										<tbody>
																											<tr>
																												<td style="border-top: 2px solid #999; font-family: Arial, Helvetica, sans-serif; font-size: 13px; text-align: center; padding-top: 10px;">
																													<p>MOTAATV  <br /> '.$chemin_absolu.'</p>
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>';
						
						
						
									//mail("hsan.trabelsi@gmail.com", $sujet, $template_mail, $headers, "-f ".$email_contact."");    
											$emails         = explode(";",$email_contact);
											$long_email     = count($emails);
											for($i=0; $i< $long_email; $i++) { 
											 //echo $emails[$i];
											  mail($emails[$i], $sujet, $template_mail, $headers, "-f ".$emails[$i]."");
											  
											  $succes="Votre message a été bien envoyé.";
											}
									
									//exit;
												// Alerte client     
												$headers  = 'MIME-Version: 1.0' . "\r\n";
												$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
												$headers .= 'From:'.$nomSite.' <no_reply@technoplus.tn>' . "\r\n";
												$sujet =sujetEmail(1);
												$contenumsg=  messageEmail(1);
												//echo $contenumsg;
												mail($email, $sujet, $contenumsg, $headers, "-f no_reply@technoplus.tn");
									
												$succes="Votre message a été bien envoyé.";
								    }
								    //exit;
                                }
								?>
								<?php
								if($succes != ""){						
								?>
								<div class="alert alert-success "><?php echo $succes;?></div>
								<?php
								}
								?>
								<div class="form-group" >
									<input class="form-control" type="text" name="name" placeholder="Nom">
								</div>

								<div class="form-group">
									<input class="form-control" type="text" name="email" placeholder="Email" required>
								</div>
								
								<div class="form-group">
									<input class="form-control" type="text" name="sujet" placeholder="Sujet" >									
								</div>

								<div class="form-group">
									<textarea class="form-control textarea-contact" rows="5" name="message" id="comment" placeholder="Ecrire votre Message ici..." required=""></textarea>
								</div>

                                <div class="form-group">
                
                    			  <div class="g-recaptcha" data-sitekey="6LffOvAoAAAAAKp9qkH1D111y3Aycr3y9oyfl1LT"></div>
                                    
                                </div>
								<button type="submit" class="btn btn-default btn-acces" value="Envoyer" data-nlok-ref-guid="e9e78eab-3ad9-4466-c759-dbbc57339687"><i class="fa fa-paper-plane"></i> Envoyer</button>
								<input type="hidden" name="action" value="send">
							</form>
						</div>
						
					
						<div class="col-md-4 col-sm-12 u-valign-top p-0 bg-section-part">
						
							<div class="p-5">
						
								<h5 class="mb-4 text-uppercase">Contactez Nous</h5> 
								<hr>
								<a href="tel:<?php echo $gsm;?>"> <p class="mb-2"> <?php echo $gsm;?> </p>	</a>							
								<a href="mailto:<?php echo $email_contact;?>"> <p class="mb-2"> <?php echo $email_contact;?></p> </a>
								
							</div>
							
						</div>
						
						<div class="col-md-4 col-sm-12 u-valign-top p-0">
						    <?php echo $map; ?>
						</div>
					</div>
				</div>
		</section>