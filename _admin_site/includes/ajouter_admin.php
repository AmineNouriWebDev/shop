<?php
if (isset($_POST['action']) && $_POST['action'] == 'ajout' )
{
	if (isset($_POST['editor_name'])) 		{$editor_name=$_POST['editor_name'];}
	if (isset($_POST['editor_surname'])) 	{$editor_surname=$_POST['editor_surname'];}
	if (isset($_POST['editor_user_name'])) 	{$editor_user_name=$_POST['editor_user_name'];}
	if (isset($_POST['editor_pass']) && $_POST['editor_pass'] != '') 		{$editor_pass=md5($_POST['editor_pass']); $mdp = $_POST['editor_pass']; }
	if (isset($_POST['editor_email'])) 		{$editor_email=$_POST['editor_email'];}
	if (isset($_POST['editor_boutique'])) 		{$editor_boutique=$_POST['editor_boutique'];}
	
	$strSQL = "SELECT * FROM editor WHERE editor_user_name='$editor_user_name'";
		$result = executeRequete($strSQL); 
		if (mysqli_num_rows($result)==0) {
		    $editor_status = '1';
			$strSQL = "INSERT INTO editor (editor_group,editor_name,editor_surname,editor_user_name,editor_pass,editor_email,mdp,editor_status) VALUES ('$editor_group', '$editor_name', '$editor_surname', '$editor_user_name', '$editor_pass', '$editor_email', '$mdp','$editor_status')";
			$result = executeRequete($strSQL) or die("Can not insert supervisor ".mysqli_error());
			$message = 'Editeur Ajouté.';
		}	
	phpToastRedirect($message, 'index.php?r=admins', 'success');
}
?>    
 <div class="row">
                    <div class="col-12">
                        <div class="admin-card">
                            <div class="admin-card-header">
                                <div class="admin-card-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1.5rem; height:1.5rem; color:var(--color-primary);">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>
                                    Ajouter administrateur
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <form method="POST" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Prénom <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="editor_surname" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Nom <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="editor_name" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Login <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="editor_user_name" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="editor_email" value="" class="admin-input" required data-validation-required-message="Ce champ est obligatoire"> </div>
                                    </div>
                                     </div>
                                    </div>
                                    
                                    <div class="row">
                                     <div class="col-md-6">
                                      <div class="admin-form-group">
                                        <label>Mot de passe <span class="text-danger">*</span></label>
                                        <div class="relative">
                                            <input type="password" name="editor_pass" id="pass" value="" class="admin-input pr-10" required data-validation-required-message="Ce champ est obligatoire">
                                            <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-primary transition-colors" onclick="changer()">
                                                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                     </div>
                                    </div>
                                                                       
                                    <div class="flex gap-3 mt-6">
                                        <button type="submit" class="admin-btn admin-btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Enregistrer
                                        </button>
                                        <button type="reset" class="admin-btn admin-btn-ghost" onclick="location.href='index.php?r=admins'">Annuler</button>
                                        <input name="action" type="hidden" id="action" value="ajout">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    let e = true;
                    function changer() {
                        const passInput = document.getElementById("pass");
                        const eyeOpen = document.getElementById("eye-open");
                        const eyeClosed = document.getElementById("eye-closed");

                        if (e) {
                            passInput.setAttribute("type", "text");
                            eyeOpen.classList.remove("hidden");
                            eyeClosed.classList.add("hidden");
                            e = false;
                        } else {
                            passInput.setAttribute("type", "password");
                            eyeOpen.classList.add("hidden");
                            eyeClosed.classList.remove("hidden");
                            e = true;
                        }
                    }
                </script>
