<div class="col-lg-12">
    <div class="messages"></div>
    <?php if(isset($succes) && $succes!=""): ?> 
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Toastify({
            text: "✅ <?php echo addslashes($succes); ?>",
            duration: 4000,
            gravity: "bottom",
            position: "right",
            className: "toast-tw",
            style: {
                background: "var(--shop-primary, #5A31F4)",
                color: "#fff",
                borderRadius: "0.75rem",
                boxShadow: "0 10px 30px rgba(90,49,244,0.3)",
                fontFamily: "Inter, sans-serif",
                fontSize: "0.875rem",
                fontWeight: "500",
                padding: "1rem 1.25rem"
            }
        }).showToast();
    });
    </script>
    <?php endif; ?>
    
    <?php if(isset($erreur) && $erreur!=""): ?> 
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Toastify({
            text: "❌ <?php echo addslashes($erreur); ?>",
            duration: 5000,
            gravity: "bottom",
            position: "right",
            className: "toast-tw",
            style: {
                background: "#ef4444",
                color: "#fff",
                borderRadius: "0.75rem",
                boxShadow: "0 10px 30px rgba(239, 68, 68, 0.3)",
                fontFamily: "Inter, sans-serif",
                fontSize: "0.875rem",
                fontWeight: "500",
                padding: "1rem 1.25rem"
            }
        }).showToast();
    });
    </script>
    <?php endif; ?>
    <div class="controls">
       
<form id="contact-form" method="post" action="<?php echo lienCompte();?>" data-toggle="validator" role="form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_name">Nom </label>
                    <input id="form_name" type="text" name="nom" value="<?php echo $nom;?>" class="form-control" placeholder="Saisir votre nom " data-error="Merci de saisir votre nom.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_name">Prénom </label>
                    <input id="form_name" type="text" name="prenom" value="<?php echo $prenom;?>" class="form-control" placeholder="Saisir votre prénom " data-error="Merci de saisir votre prénom.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_tel">Téléphone </label>
                    <input id="form_tel" type="text" name="tel" value="<?php echo $tel;?>" class="form-control" placeholder="Saisir votre numéro de téléphone " data-error="Saisir un numéro de téléphone.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_email">E-mail <span style="color: red;font-size: 10px">Non modifiable</span> </label>
                    <input id="form_email" type="email" name="email" value="<?php echo $email;?>" class="form-control" placeholder="Saisir votre adresse e-mail " data-error="Merci de saisir une adresse e-mail valide." disabled>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="form_adr">Adresse </label>
                    <input id="form_adr" type="text" name="adresse" value="<?php echo $adresse;?>" class="form-control" placeholder="Saisir votre adresse " data-error="Saisir une adresse.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_adr">Ville </label>
                    <input id="form_adr" type="text" name="ville" value="<?php echo $ville;?>" class="form-control" placeholder="Saisir votre ville " data-error="Saisir une ville.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_adr">Code postal </label>
                    <input id="form_adr" type="text" name="cp" value="<?php echo $cp;?>" class="form-control" placeholder="Saisir votre code postal " data-error="Saisir un code postal.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <input type="hidden" name="action" value="infos">
                <input type="submit" class="btn btn-info btn-send" value="Enregistrer">
            </div>
        </div>
</form>

<form id="contact-form" method="post" action="<?php echo lienCompte();?>" data-toggle="validator" role="form">
        <div class="row">
            <h5 class="p-3"> Changer le mot de passe </h5>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="form_email">Mot de passe actuel <strong style='color: #e82069;'>*</strong></label>
                    <input id="form_email" type="password" name="current_password" value="" class="form-control" placeholder="Saisir votre mot de passe *" data-error="Merci de saisir mot de passe valide valide." required >
                    <div class="help-block with-errors"></div>
                </div>    
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_email">Nouveau mot de passe <strong style='color: #e82069;'>*</strong></label>
                    <input id="form_email" type="password" name="new_password" value="" class="form-control" placeholder="Saisir votre nouveau mot de passe *" data-error="Merci de saisir mot de passe valide valide." required >
                    <div class="help-block with-errors"></div>
                </div>    
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_email">Confirmer mot de passe <strong style='color: #e82069;'>*</strong></label>
                    <input id="form_email" type="password" name="confirm_password" value="" class="form-control" placeholder="Confirmer votre mot de passe *" data-error="Merci de saisir mot de passe valide valide." required >
                    <div class="help-block with-errors"></div>
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <input type="hidden" name="action" value="mdp">
                <input type="submit" class="btn btn-info btn-send" value="Enregistrer">
            </div>
        </div>
</form>
        <div class="row">
            <div class="col-md-12">
                <p class="text-muted">
                    <strong>*</strong> Ces champs sont obligatoires.</p>
            </div>
        </div>
    </div>
</div>