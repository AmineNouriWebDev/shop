<?php
ob_start();
session_start();
include("includes/include.php");
$erreur = false;
$msg = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $turnstile_valid = true;
    if (!empty($cloudflare_secret_key)) {
        $turnstile_response = $_POST['cf-turnstile-response'] ?? '';
        $verify_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
        $data_cf = [
            'secret' => $cloudflare_secret_key,
            'response' => $turnstile_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $verify_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data_cf));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        $response_keys = json_decode($result, true);
        if(empty($response_keys) || empty($response_keys['success'])) {
            $turnstile_valid = false;
        }
    }

    if (!$turnstile_valid) {
        $erreur = true;
        $msg = "La vérification anti-spam a échoué. Veuillez réessayer."; 
    } else {
      $login = formReception($_POST['editor_user']);
      $pass = md5(formReception($_POST['editor_pass']));
	$strSQL  ='SELECT * FROM editor WHERE editor_user_name="'.$login.'" AND editor_pass="'.$pass.'" AND `editor_status`=1';
	$result = executeRequete($strSQL);
	$erreur=false;
		if (mysqli_num_rows($result)==0)
		{
		$erreur=true;
		$msg="Identifiants invalides. Veuillez vérifier et réessayer."; 
		}
			else
			{
				$row = mysqli_fetch_array($result);
			$erreur=false;
			$sess_id = md5(microtime());
			$_SESSION['editor_id']=$row['editor_id'];
			$_SESSION['editor_login']=$row['editor_user_name'];
			$_SESSION['editor_group']=$row['editor_group'];
			$_SESSION['editor_name']=$row['editor_name'];
			$_SESSION['editor_surname']=$row['editor_surname'];
			$_SESSION['sess_id'] = $sess_id;
			$strSQL1 = "UPDATE `editor` SET ses_id='$sess_id' WHERE editor_id='$row[editor_id]' ";
			$result1 = mysqli_query($connexion,$strSQL1) or die($strSQL1.' '.mysqli_error($connexion));
			$entree = time();
            $ip_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
			$rq = 'INSERT INTO `editor_state` ( `editor_id`, `entree`, `sess_id`, `ip`) VALUES ( "'. $row['editor_id'] .'", "'. $entree .'", "'. $sess_id .'", "'. $ip_addr .'" ) ';
			$rs = mysqli_query($connexion,$rq);
             if (!headers_sent()) {
                 header("location: index.php");
             } else {
                 echo '<script>window.location.href="index.php";</script>';
             }
			 exit();
			}
    }
   }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — <?php echo htmlspecialchars($nom_site ?? 'Dashboard'); ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="../media/site/<?php echo $favicon; ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        if (localStorage.getItem('admin_dark_mode') === '1') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #5a31f4;
            --primary-light: #7c5af6;
            --secondary: #0ea5e9;
            --accent: #f43f5e;
            --bg: #0f0c1d;
            --card: rgba(255,255,255,0.06);
            --card-border: rgba(255,255,255,0.12);
            --text: #EDE9FF;
            --text-muted: #9B96BB;
            --input-bg: rgba(255,255,255,0.07);
            --input-border: rgba(255,255,255,0.15);
            --input-focus: #5a31f4;
            --error-bg: rgba(244, 63, 94, 0.15);
            --error-border: rgba(244, 63, 94, 0.4);
        }

        html, body {
            height: 100%;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow: hidden;
        }

        /* ── Animated Background ── */
        .login-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: radial-gradient(ellipse 80% 60% at 20% 10%, rgba(90,49,244,0.35) 0%, transparent 60%),
                        radial-gradient(ellipse 60% 50% at 80% 90%, rgba(14,165,233,0.25) 0%, transparent 60%),
                        radial-gradient(ellipse 50% 40% at 60% 40%, rgba(244,63,94,0.1) 0%, transparent 50%),
                        #0f0c1d;
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: floatOrb 12s ease-in-out infinite alternate;
        }
        .orb-1 {
            width: 500px; height: 500px;
            background: rgba(90,49,244,0.25);
            top: -150px; left: -150px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 400px; height: 400px;
            background: rgba(14,165,233,0.2);
            bottom: -100px; right: -100px;
            animation-delay: -4s;
        }
        .orb-3 {
            width: 300px; height: 300px;
            background: rgba(244,63,94,0.15);
            top: 40%; left: 60%;
            animation-delay: -8s;
        }

        @keyframes floatOrb {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, -40px) scale(1.1); }
        }

        /* Grid overlay */
        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(90,49,244,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(90,49,244,0.06) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black 40%, transparent 100%);
        }

        /* ── Layout ── */
        .login-shell {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* ── Card ── */
        .login-card {
            width: 100%;
            max-width: 440px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.04) inset;
            animation: cardIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(32px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }

        /* ── Brand ── */
        .login-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }
        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 24px rgba(90,49,244,0.5);
            flex-shrink: 0;
        }
        .brand-icon svg { width: 22px; height: 22px; color: #fff; }
        .brand-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.01em;
        }
        .brand-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ── Heading ── */
        .login-heading {
            margin-bottom: 0.5rem;
        }
        .login-heading h1 {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #fff 30%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }
        .login-heading p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.375rem;
        }

        .login-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--card-border), transparent);
            margin: 1.5rem 0;
        }

        /* ── Error ── */
        .login-error {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.8125rem;
            color: #fca5a5;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .login-error svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }

        /* ── Field ── */
        .field {
            position: relative;
            margin-bottom: 1.125rem;
        }
        .field-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            width: 18px; height: 18px;
            transition: color 0.2s;
            pointer-events: none;
        }
        .field-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.875rem;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--input-border);
            border-radius: 0.75rem;
            font-family: inherit;
            font-size: 0.9rem;
            color: #000;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            -webkit-text-fill-color: #000;
        }
        .field-input::placeholder { color: var(--text-muted); -webkit-text-fill-color: var(--text-muted); }
        .field-input:focus {
            border-color: var(--input-focus);
            background: rgba(90,49,244,0.08);
            box-shadow: 0 0 0 3px rgba(90,49,244,0.2);
        }
        .field-input:focus ~ .field-icon,
        .field:focus-within .field-icon {
            color: var(--primary-light);
        }

        /* Toggle password */
        .field-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            transition: color 0.2s;
            line-height: 0;
        }
        .field-toggle:hover { color: var(--primary-light); }
        .field-toggle svg { width: 18px; height: 18px; }

        /* ── Options ── */
        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: var(--text-muted);
            cursor: pointer;
        }
        .remember input[type="checkbox"] {
            accent-color: var(--primary);
            width: 15px; height: 15px;
            cursor: pointer;
        }
        .forgot-link {
            font-size: 0.8125rem;
            color: var(--primary-light);
            text-decoration: none;
            transition: color 0.2s, opacity 0.2s;
        }
        .forgot-link:hover { opacity: 0.8; }

        /* ── Submit Button ── */
        .btn-login {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--primary) 0%, #7c3af4 50%, var(--secondary) 100%);
            background-size: 200% 100%;
            background-position: 0% 0%;
            border: none;
            border-radius: 0.75rem;
            color: #fff;
            font-family: inherit;
            font-size: 0.9375rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: background-position 0.4s, box-shadow 0.2s, transform 0.15s;
            box-shadow: 0 4px 20px rgba(90,49,244,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            border-radius: inherit;
        }
        .btn-login:hover {
            background-position: 100% 0%;
            box-shadow: 0 8px 32px rgba(90,49,244,0.55), 0 0 0 1px rgba(255,255,255,0.1) inset;
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login svg { width: 18px; height: 18px; }

        /* ── Back link ── */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            margin-top: 1.5rem;
            font-size: 0.8125rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-link svg { width: 14px; height: 14px; transition: transform 0.2s; }
        .back-link:hover { color: var(--primary-light); }
        .back-link:hover svg { transform: translateX(-3px); }

        /* ── Recovery Form ── */
        .recover-wrap { display: none; }
        .recover-wrap.open { display: block; animation: cardIn 0.4s both; }
        .recover-back {
            background: none;
            border: none;
            color: var(--primary-light);
            font-size: 0.8125rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0;
            margin-bottom: 1.25rem;
            font-family: inherit;
            transition: opacity 0.2s;
        }
        .recover-back:hover { opacity: 0.8; }
        .recover-back svg { width: 14px; height: 14px; }

        /* ── Pulse dot ── */
        .status-dot {
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #10b981;
            margin-right: 6px;
            animation: pulse-dot 2s ease-in-out infinite;
            flex-shrink: 0;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.4); }
        }
        .sys-status {
            display: flex;
            align-items: center;
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-top: 1.75rem;
            justify-content: center;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .login-card { padding: 2rem 1.5rem; border-radius: 1.25rem; }
        }
    </style>
</head>
<body>
    <!-- Animated background -->
    <div class="login-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="grid-overlay"></div>
    </div>

    <div class="login-shell">
        <div class="login-card">

            <!-- Brand -->
            <div class="login-brand">
                <div class="brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
                <div>
                    <div class="brand-name"><?php echo htmlspecialchars($nom_site ?? 'Admin'); ?></div>
                    <div class="brand-sub">Panneau d'administration</div>
                </div>
            </div>

            <!-- ─── Login Form ─── -->
            <div id="loginWrap">
                <div class="login-heading">
                    <h1>Bon retour 👋</h1>
                    <p>Connectez-vous pour accéder à votre espace.</p>
                </div>

                <div class="login-divider"></div>

                <?php if($erreur && $msg != ""): ?>
                <div class="login-error">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo htmlspecialchars($msg); ?>
                </div>
                <?php endif; ?>

                <form id="loginform" action="" method="post">

                    <!-- Username -->
                    <div class="field">
                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                        <input class="field-input" type="text" name="editor_user" id="editor_user" autocomplete="username" required placeholder="Nom d'utilisateur">
                    </div>

                    <!-- Password -->
                    <div class="field">
                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                        </svg>
                        <input class="field-input" type="password" name="editor_pass" id="editor_pass" autocomplete="current-password" required placeholder="Mot de passe">
                        <button type="button" class="field-toggle" id="togglePass" aria-label="Afficher/Masquer le mot de passe">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Options -->
                    <div class="login-options">
                        <label class="remember">
                            <input type="checkbox" id="remember"> Se souvenir de moi
                        </label>
                        <a href="#" class="forgot-link" id="toRecover">Mot de passe oublié ?</a>
                    </div>

                    <?php if (!empty($cloudflare_site_key)): ?>
                        <div class="cf-turnstile mb-3" data-sitekey="<?php echo $cloudflare_site_key; ?>" data-theme="dark"></div>
                    <?php endif; ?>

                    <!-- Submit -->
                    <button type="submit" class="btn-login">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                        </svg>
                        Se connecter
                    </button>
                </form>

                <!-- Back to site -->
                <a href="<?php echo htmlspecialchars($chemin_absolu ?? '/'); ?>" class="back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Retour au site — <?php echo htmlspecialchars($nom_site ?? ''); ?>
                </a>

                <div class="sys-status">
                    <span class="status-dot"></span>
                    Tous les systèmes opérationnels
                </div>
            </div>

            <!-- ─── Recovery Form ─── -->
            <div class="recover-wrap" id="recoverWrap">
                <button class="recover-back" id="backToLogin">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Retour à la connexion
                </button>

                <div class="login-heading">
                    <h1>Récupérer l'accès 🔑</h1>
                    <p>Entrez votre email pour recevoir les instructions.</p>
                </div>

                <div class="login-divider"></div>

                <form id="recoverform" action="">
                    <div class="field">
                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                        </svg>
                        <input class="field-input" type="email" placeholder="Votre adresse email">
                    </div>
                    <button type="submit" class="btn-login">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                        </svg>
                        Envoyer les instructions
                    </button>
                </form>
            </div>

        </div><!-- /.login-card -->
    </div><!-- /.login-shell -->

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePass');
        const passInput = document.getElementById('editor_pass');
        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', () => {
                const isText = passInput.type === 'text';
                passInput.type = isText ? 'password' : 'text';
                toggleBtn.querySelector('svg').style.opacity = isText ? '1' : '0.5';
            });
        }

        // Switch to recovery form
        const toRecover = document.getElementById('toRecover');
        const loginWrap = document.getElementById('loginWrap');
        const recoverWrap = document.getElementById('recoverWrap');
        const backToLogin = document.getElementById('backToLogin');

        if (toRecover) {
            toRecover.addEventListener('click', (e) => {
                e.preventDefault();
                loginWrap.style.display = 'none';
                recoverWrap.classList.add('open');
            });
        }
        if (backToLogin) {
            backToLogin.addEventListener('click', () => {
                recoverWrap.classList.remove('open');
                loginWrap.style.display = '';
            });
        }
    </script>
</body>
</html>