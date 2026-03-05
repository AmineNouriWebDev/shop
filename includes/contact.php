<div class="container-fluid p-0">
    <div class="row g-4">
        <!-- Contact Form Column -->
        <div class="col-lg-7">
            <div class="cx-surface cx-border p-4 p-md-5 rounded-3xl shadow-sm h-100">
                <h2 class="h4 fw-bold mb-4" style="color:var(--shop-primary);">Envoyez-nous un message</h2>
                <p class="text-secondary mb-4">Une question ou une suggestion ? Notre équipe vous répondra dans les plus brefs délais.</p>

                <form method="post" action="" data-toggle="validator" role="form" class="contact-form" enctype="multipart/form-data">
                    <?php
                    $succes = ""; 
                    if(isset($_POST['action']) && $_POST['action']=="send"){
                        
                        // Cloudflare Turnstile Validation
                        $turnstile_response = $_POST['cf-turnstile-response'] ?? '';
                        
                        // Verification CURL
                        $verify_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
                        $data = [
                            'secret' => $cloudflare_secret_key,
                            'response' => $turnstile_response,
                            'remoteip' => $_SERVER['REMOTE_ADDR']
                        ];
                        
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $verify_url);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        
                        // Ignorer la vérification SSL en local pour éviter les erreurs cURL locales
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        
                        $result = curl_exec($curl);
                        curl_close($curl);
                        
                        $response_keys = json_decode($result, true);
                        
                        // Si le json_decode a échoué ou que "success" n'est pas "true"
                        if(empty($response_keys) || empty($response_keys['success'])) {
                            echo '<div class="alert alert-danger rounded-xl mb-4">La vérification anti-spam a échoué. Veuillez réessayer.</div>';
                        } else {
                            $nom=sanitize($_POST['name']);
                            $email=sanitize($_POST['email']);
                            $sujet=sanitize($_POST['sujet']);
                            $message=sanitize($_POST['message']);
                            $date_creation=time();

                            $requete1 = 'INSERT INTO `messages` (`nom`, `email`, `sujet`,`contenu`, `date`) VALUES ("'.$nom.'", "'.$email.'", "'.$sujet.'", "'.$message.'","'. $date_creation .'")';
                            executeRequete($requete1);

                            // Email logic
                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                            $headers .= 'From:'.$nom_site.' <no_reply@technoplus.tn>' . "\r\n";
                            
                            $template_mail='<div style="font-family:sans-serif; padding:20px; background:#f4f4f4;">
                                <div style="max-width:600px; margin:0 auto; background:#fff; padding:30px; border-radius:10px;">
                                    <h2 style="color:#5A31F4;">Nouveau Contact</h2>
                                    <p><strong>Nom:</strong> '.$nom.'</p>
                                    <p><strong>Email:</strong> '.$email.'</p>
                                    <p><strong>Sujet:</strong> '.$sujet.'</p>
                                    <p><strong>Message:</strong><br>'.nl2br($message).'</p>
                                </div>
                            </div>';
                            
                            $emails = explode(";",$email_contact);
                            foreach($emails as $admin_email) { 
                                // On utilise @ pour ignorer l'erreur d'envoi en local (SMTP non configuré)
                                @mail(trim($admin_email), $sujet, $template_mail, $headers);
                            }
                            
                            $succes="Votre message a été bien envoyé.";
                        }
                    }
                    if($succes != ""){						
                        echo '<div class="alert alert-success rounded-xl mb-4">'.$succes.'</div>';
                    }
                    ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small fw-bold mb-2 text-secondary">Nom & Prénom</label>
                            <input class="cx-input" type="text" name="name" placeholder="Ex: Jean Dupont" required>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-2 text-secondary">Adresse Email</label>
                            <input class="cx-input" type="email" name="email" placeholder="email@exemple.com" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="small fw-bold mb-2 text-secondary">Sujet</label>
                            <input class="cx-input" type="text" name="sujet" placeholder="De quoi s'agit-il ?" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="small fw-bold mb-2 text-secondary">Message</label>
                            <textarea class="cx-input" rows="6" name="message" placeholder="Votre message ici..." required style="resize: none;"></textarea>
                        </div>
                        <div class="col-12 mt-3">
                            <!-- Cloudflare Turnstile Widget -->
                            <?php if (!empty($cloudflare_site_key)): ?>
                                <div class="cf-turnstile mb-3" data-sitekey="<?php echo $cloudflare_site_key; ?>"></div>
                            <?php else: ?>
                                <div class="alert alert-warning small py-2 mb-3">La clé Cloudflare n'est pas configurée dans l'administration.</div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="cx-btn w-100 py-3 shadow-lg">
                                <i class="fa fa-paper-plane"></i> Envoyer le message
                            </button>
                        </div>
                        <input type="hidden" name="action" value="send">
                    </div>
                </form>
            </div>
        </div>

        <!-- Info & Map Column -->
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4 h-100">
                <!-- Contact Info Card -->
                <div class="cx-surface cx-border p-4 p-md-5 rounded-3xl shadow-sm">
                    <h2 class="h4 fw-bold mb-4" style="color:var(--shop-primary);">Nos Coordonnées</h2>
                    
                    <div class="d-flex align-items-center gap-4 mb-4 pb-3 border-bottom border-light" style="border-color: var(--shop-border)!important;">
                        <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-primary-subtle rounded-3" style="width: 50px; height: 50px; background: color-mix(in srgb, var(--shop-primary) 10%, transparent);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--shop-primary);"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div>
                            <p class="small text-secondary mb-0">Téléphone</p>
                            <a href="tel:<?php echo $gsm;?>" class="fw-bold text-decoration-none text-primary fs-5"><?php echo $gsm;?></a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-4 mb-0">
                        <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-primary-subtle rounded-3" style="width: 50px; height: 50px; background: color-mix(in srgb, var(--shop-primary) 10%, transparent);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--shop-primary);"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="small text-secondary mb-0">Email</p>
                            <a href="mailto:<?php echo $email_contact;?>" class="fw-bold text-decoration-none text-primary fs-5"><?php echo $email_contact;?></a>
                        </div>
                    </div>
                </div>

                <!-- Map Card -->
                <div class="cx-surface cx-border p-2 rounded-3xl shadow-sm flex-grow-1 overflow-hidden" style="min-height: 400px;">
                    <div class="w-100 h-100 rounded-2xl overflow-hidden shadow-inner">
                        <?php 
                        // Clean map embed to ensure it fits perfectly
                        $clean_map = str_replace(['width="600"', 'height="450"', 'border:0;', 'style="border:0;"'], ['width="100%"', 'height="100%"', '', 'style="filter: grayscale(0.2); border:0;"'], $map);
                        echo $clean_map; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>