<?php
include("include.php");

// Handle AJAX Submission
if (isset($_POST['action']) && $_POST['action'] === 'submit_diagnostic') {
    $type_batiment = sanitize($_POST['type_batiment'] ?? '');
    $type_camera   = sanitize($_POST['type_camera'] ?? '');
    $zones         = sanitize($_POST['zones'] ?? ''); // Expecting JSON or comma-separated
    $raisons       = sanitize($_POST['raisons'] ?? ''); // Expecting JSON or comma-separated
    $alimentation  = sanitize($_POST['alimentation'] ?? '');
    $nom           = sanitize($_POST['nom'] ?? '');
    $prenom        = sanitize($_POST['prenom'] ?? '');
    $adresse       = sanitize($_POST['adresse'] ?? '');
    $telephone     = sanitize($_POST['telephone'] ?? '');
    $whatsapp      = isset($_POST['whatsapp']) && $_POST['whatsapp'] === '1' ? 1 : 0;

    $sql = "INSERT INTO diagnostic_demandes (type_batiment, type_camera, zones, raisons, alimentation, nom, prenom, adresse, telephone, whatsapp) 
            VALUES ('$type_batiment', '$type_camera', '$zones', '$raisons', '$alimentation', '$nom', '$prenom', '$adresse', '$telephone', '$whatsapp')";
    
    if (mysqli_query($connexion, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Demande enregistrée']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connexion)]);
    }
    exit;
}

$titre = "Diagnostic Sécurité Personnalisé";
$title_page = "Diagnostic Sécurité | Offipro";
$description_page = "Réalisez votre diagnostic sécurité en quelques étapes pour protéger votre maison, appartement ou entreprise.";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/script-header.php');?>
    <style>
        :root {
            --diag-primary: #3b82f6;
            --diag-primary-hover: #2563eb;
            --diag-bg: var(--shop-bg-base);
            --diag-surface: var(--shop-surface);
            --diag-border: var(--shop-border);
            --diag-text: var(--shop-text-primary);
            --diag-text-muted: var(--shop-text-secondary);
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--diag-bg);
            color: var(--diag-text);
            min-height: 100vh;
        }

        .diag-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .diag-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .diag-title {
            font-size: clamp(1.5rem, 5vw, 2.25rem);
            font-weight: 800;
            color: var(--diag-text);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .diag-subtitle {
            font-size: 1rem;
            color: var(--diag-text-muted);
            max-width: 500px;
            margin: 0 auto;
        }

        /* ── Progress Bar ── */
        .diag-progress-container {
            width: 100%;
            background: var(--diag-border);
            height: 6px;
            border-radius: 3px;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .diag-progress-bar {
            position: absolute;
            top: 0; left: 0; bottom: 0;
            width: 0%;
            background: var(--diag-primary);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .diag-step-counter {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--diag-primary);
            margin-bottom: 0.75rem;
            text-align: center;
        }

        /* ── Steps ── */
        .diag-step {
            display: none;
            width: 100%;
            animation: fadeInSlide 0.5s ease forwards;
        }

        .diag-step.active {
            display: block;
        }

        @keyframes fadeInSlide {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .diag-question {
            font-size: 1.25rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* ── Cards Grid ── */
        .diag-options-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.25rem;
            width: 100%;
            justify-content: center;
        }

        @media (min-width: 480px) {
            .diag-options-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .diag-options-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            /* Logic to center the last row if fewer items */
            .diag-step[data-step] .diag-options-grid {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .diag-step[data-step] .diag-option-card {
                width: calc(33.333% - 1rem);
                max-width: 280px;
                flex-grow: 0;
            }
        }

        .diag-option-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1rem;
            padding: 1.75rem 1rem;
            background: var(--diag-surface);
            border: 2px solid var(--diag-border);
            border-radius: 1.25rem;
            cursor: pointer;
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            min-height: 160px;
            justify-content: center;
            box-sizing: border-box;
        }

        .diag-option-card:hover {
            border-color: var(--diag-primary);
            background: color-mix(in srgb, var(--diag-primary) 5%, var(--diag-surface));
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .diag-option-card.selected {
            border-color: var(--diag-primary);
            background: color-mix(in srgb, var(--diag-primary) 10%, var(--diag-surface));
            box-shadow: 0 10px 20px color-mix(in srgb, var(--diag-primary) 20%, transparent);
        }

        .diag-option-icon {
            width: 64px;
            height: 64px;
            background: color-mix(in srgb, var(--diag-primary) 10%, transparent);
            color: var(--diag-primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
            transition: transform 300ms ease;
        }

        .diag-option-card:hover .diag-option-icon {
            transform: scale(1.1);
        }

        .diag-option-text {
            font-weight: 700;
            font-size: 1.05rem;
            line-height: 1.3;
            color: var(--diag-text);
        }

        /* ── Hidden selection circle moved to bottom right ── */
        .diag-option-check {
            position: absolute;
            bottom: 0.75rem;
            right: 0.75rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid var(--diag-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.6rem;
            transition: all 250ms ease;
            background: var(--diag-surface);
            opacity: 0.4; /* Subtle when not selected */
        }

        .diag-option-card.selected .diag-option-check {
            background: var(--diag-primary);
            border-color: var(--diag-primary);
            opacity: 1;
        }

        /* ── Form Inputs ── */
        .diag-form-group {
            margin-bottom: 1.25rem;
            width: 100%;
        }

        .diag-form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--diag-text-muted);
            margin-bottom: 0.5rem;
        }

        .diag-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            border: 1.5px solid var(--diag-border);
            background: var(--diag-bg);
            color: var(--diag-text);
            font-family: inherit;
            font-size: 1rem;
            outline: none;
            transition: border-color 200ms ease;
        }

        .diag-input:focus {
            border-color: var(--diag-primary);
        }

        .diag-checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 0;
        }

        .diag-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1.5px solid var(--diag-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
        }

        .diag-checkbox.checked {
            background: var(--diag-primary);
            border-color: var(--diag-primary);
        }

        /* ── Buttons ── */
        .diag-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 3rem;
            width: 100%;
        }

        .diag-btn {
            padding: 0.875rem 2.5rem;
            border-radius: 0.875rem;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 200ms ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .diag-btn-primary {
            background: var(--diag-primary);
            color: white;
        }

        .diag-btn-primary:hover {
            background: var(--diag-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .diag-btn-outline {
            background: transparent;
            color: var(--diag-text);
            border: 1.5px solid var(--diag-border);
        }

        .diag-btn-outline:hover {
            background: var(--diag-border);
        }

        /* ── Final Step ── */
        .diag-final {
            text-align: center;
        }

        .diag-success-icon {
            font-size: 4rem;
            color: #10b981;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <?php include('includes/header-tw.php');?>

    <main class="diag-wrapper">
        <div class="diag-header" id="diag-header">
            <h1 class="diag-title">Complétez votre diagnostic sécurité</h1>
            <p class="diag-subtitle">En complétant ce formulaire, personnalisez votre diagnostic sécurité pour l’adapter à vos besoins.</p>
        </div>

        <div id="diag-main-content" style="width:100%;">
            <div class="diag-step-counter" id="diag-step-counter">Étape 1 / 6</div>
            <div class="diag-progress-container">
                <div class="diag-progress-bar" id="diag-progress-bar"></div>
            </div>

            <!-- Step 1: Que souhaitez-vous protéger ? -->
            <div class="diag-step active" data-step="1">
                <h2 class="diag-question">Que souhaitez-vous protéger ?</h2>
                <div class="diag-options-grid">
                    <div class="diag-option-card" onclick="selectOption('type_batiment', 'Ma maison', true)">
                        <div class="diag-option-icon"><i class="fa fa-home"></i></div>
                        <div class="diag-option-text">Ma maison</div>
                        <div class="diag-option-check"></div>
                    </div>
                    <div class="diag-option-card" onclick="selectOption('type_batiment', 'Mon appartement', true)">
                        <div class="diag-option-icon"><i class="fa fa-building"></i></div>
                        <div class="diag-option-text">Mon appartement</div>
                        <div class="diag-option-check"></div>
                    </div>
                    <div class="diag-option-card" onclick="selectOption('type_batiment', 'Mon entreprise', true)">
                        <div class="diag-option-icon"><i class="fa fa-briefcase"></i></div>
                        <div class="diag-option-text">Mon entreprise</div>
                        <div class="diag-option-check"></div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Type de caméra -->
            <div class="diag-step" data-step="2">
                <h2 class="diag-question">Avec quel type de caméra souhaitez vous être équipé ?</h2>
                <div class="diag-options-grid">
                    <div class="diag-option-card" onclick="selectOption('type_camera', 'Caméra intérieure', true)">
                        <div class="diag-option-icon"><i class="fa fa-video-camera"></i></div>
                        <div class="diag-option-text">Caméra intérieure</div>
                        <div class="diag-option-check"></div>
                    </div>
                    <div class="diag-option-card" onclick="selectOption('type_camera', 'Caméra intérieure et extérieure', true)">
                        <div class="diag-option-icon"><i class="fa fa-shield"></i></div>
                        <div class="diag-option-text">Caméra intérieure et extérieure</div>
                        <div class="diag-option-check"></div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Zones à sécuriser (Multiple) -->
            <div class="diag-step" data-step="3">
                <h2 class="diag-question">Quelles zones souhaitez vous sécuriser ?<br><small style="font-size:0.8rem; font-weight:normal;">Plusieurs choix possibles</small></h2>
                <div class="diag-options-grid">
                    <div class="diag-option-card" onclick="toggleMultiOption('zones', 'Mon entrée')">
                        <div class="diag-option-icon"><i class="fa fa-sign-in"></i></div>
                        <div class="diag-option-text">Mon entrée</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="diag-option-card" onclick="toggleMultiOption('zones', 'Mon salon')">
                        <div class="diag-option-icon"><i class="fa fa-television"></i></div>
                        <div class="diag-option-text">Mon salon</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="diag-option-card" onclick="toggleMultiOption('zones', 'Mon jardin')">
                        <div class="diag-option-icon"><i class="fa fa-leaf"></i></div>
                        <div class="diag-option-text">Mon jardin</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="diag-option-card" onclick="toggleMultiOption('zones', 'Mon garage')">
                        <div class="diag-option-icon"><i class="fa fa-car"></i></div>
                        <div class="diag-option-text">Mon garage</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="diag-option-card" onclick="toggleMultiOption('zones', 'Autres')">
                        <div class="diag-option-icon"><i class="fa fa-ellipsis-h"></i></div>
                        <div class="diag-option-text">Autres</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                </div>
                <div class="diag-actions">
                    <button class="diag-btn diag-btn-primary" onclick="nextStep()">Valider</button>
                </div>
            </div>

            <!-- Step 4: Raisons (Multiple) -->
            <div class="diag-step" data-step="4">
                <h2 class="diag-question">Quelles sont les raisons principales de votre besoin ?<br><small style="font-size:0.8rem; font-weight:normal;">Plusieurs choix possibles</small></h2>
                <div class="diag-options-grid">
                    <div class="diag-option-card" onclick="toggleMultiOption('raisons', 'Sécurité des personnes')">
                        <div class="diag-option-icon"><i class="fa fa-users"></i></div>
                        <div class="diag-option-text">Sécurité des personnes</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="diag-option-card" onclick="toggleMultiOption('raisons', 'Sécurité des animaux')">
                        <div class="diag-option-icon"><i class="fa fa-paw"></i></div>
                        <div class="diag-option-text">Sécurité des animaux</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="diag-option-card" onclick="toggleMultiOption('raisons', 'Sécurité des biens')">
                        <div class="diag-option-icon"><i class="fa fa-cube"></i></div>
                        <div class="diag-option-text">Sécurité des biens</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="diag-option-card" onclick="toggleMultiOption('raisons', 'Autre')">
                        <div class="diag-option-icon"><i class="fa fa-question-circle"></i></div>
                        <div class="diag-option-text">Autre</div>
                        <div class="diag-option-check"><i class="fa fa-check"></i></div>
                    </div>
                </div>
                <div class="diag-actions">
                    <button class="diag-btn diag-btn-primary" onclick="nextStep()">Valider</button>
                </div>
            </div>

            <!-- Step 5: Alimentation -->
            <div class="diag-step" data-step="5">
                <h2 class="diag-question">Souhaitez-vous une caméra avec batterie ou sur secteur ?</h2>
                <div class="diag-options-grid">
                    <div class="diag-option-card" onclick="selectOption('alimentation', 'Batterie', true)">
                        <div class="diag-option-icon"><i class="fa fa-battery-full"></i></div>
                        <div class="diag-option-text">Batterie</div>
                        <div class="diag-option-check"></div>
                    </div>
                    <div class="diag-option-card" onclick="selectOption('alimentation', 'Secteur', true)">
                        <div class="diag-option-icon"><i class="fa fa-plug"></i></div>
                        <div class="diag-option-text">Secteur</div>
                        <div class="diag-option-check"></div>
                    </div>
                </div>
            </div>

            <!-- Step 6: Coordonnées -->
            <div class="diag-step" data-step="6">
                <h2 class="diag-question">Vos coordonnées</h2>
                <div style="max-width:500px; margin:0 auto;">
                    <div class="diag-form-group">
                        <label class="diag-form-label">Nom</label>
                        <input type="text" id="diag_nom" class="diag-input" placeholder="Votre nom">
                    </div>
                    <div class="diag-form-group">
                        <label class="diag-form-label">Prénom</label>
                        <input type="text" id="diag_prenom" class="diag-input" placeholder="Votre prénom">
                    </div>
                    <div class="diag-form-group">
                        <label class="diag-form-label">Adresse (Facultatif)</label>
                        <input type="text" id="diag_adresse" class="diag-input" placeholder="Votre adresse">
                    </div>
                    <div class="diag-form-group">
                        <label class="diag-form-label">Téléphone</label>
                        <input type="tel" id="diag_tel" class="diag-input" placeholder="Votre numéro">
                    </div>
                    <div class="diag-checkbox-group" onclick="toggleWhatsapp()">
                        <div id="diag_whatsapp_checkbox" class="diag-checkbox"><i class="fa fa-check"></i></div>
                        <span style="font-size:0.9rem;">Mon numéro est inscrit à WhatsApp</span>
                    </div>
                    <div class="diag-actions">
                        <button class="diag-btn diag-btn-primary" style="width:100%;" id="diag-submit-btn" onclick="submitDiagnostic()">
                            Finaliser mon diagnostic
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 7: Merci -->
            <div class="diag-step" data-step="7">
                <div class="diag-final">
                    <div class="diag-success-icon"><i class="fa fa-check-circle"></i></div>
                    <h2 class="diag-question">Merci pour votre confiance !</h2>
                    <p style="margin-bottom:2rem; color:var(--diag-text-muted);">Nous avons bien reçu votre diagnostic. Un conseiller Offipro vous contactera très prochainement pour affiner votre projet.</p>
                    
                    <div style="padding:2rem; background:color-mix(in srgb, var(--diag-primary) 5%, var(--diag-surface)); border-radius:1rem; border:1px dashed var(--diag-primary);">
                        <p style="font-weight:600; margin-bottom:1rem;">Vous souhaitez configurer vous-même votre système en attendant ?</p>
                        <a href="<?php echo $chemin_absolu; ?>configurateur-camera/" class="diag-btn diag-btn-primary" style="display:inline-flex; text-decoration:none;">
                            <i class="fa fa-cog"></i> Ouvrir le configurateur en ligne
                        </a>
                    </div>
                </div>
            </div>

            <div class="diag-actions" id="diag-nav-actions" style="margin-top:2rem;">
                <button id="diag-btn-prev" class="diag-btn diag-btn-outline" style="display:none;" onclick="prevStep()">
                    <i class="fa fa-arrow-left"></i> Précédent
                </button>
            </div>
        </div>
    </main>

    <?php include('includes/footer-tw.php');?>

    <script>
        const state = {
            currentStep: 1,
            totalSteps: 6,
            responses: {
                type_batiment: '',
                type_camera: '',
                zones: [],
                raisons: [],
                alimentation: '',
                nom: '',
                prenom: '',
                adresse: '',
                telephone: '',
                whatsapp: 0
            }
        };

        function updateProgress() {
            const bar = document.getElementById('diag-progress-bar');
            const counter = document.getElementById('diag-step-counter');
            const progress = (state.currentStep / state.totalSteps) * 100;
            
            bar.style.width = Math.min(progress, 100) + '%';
            
            if (state.currentStep <= state.totalSteps) {
                counter.innerText = `Étape ${state.currentStep} / ${state.totalSteps}`;
            } else {
                counter.style.display = 'none';
            }

            // Show/Hide prev button
            const btnPrev = document.getElementById('diag-btn-prev');
            btnPrev.style.display = (state.currentStep > 1 && state.currentStep <= state.totalSteps) ? 'inline-flex' : 'none';

            // Hide header on final step
            if (state.currentStep === 7) {
                document.getElementById('diag-header').style.display = 'none';
                document.getElementById('diag-nav-actions').style.display = 'none';
            }
        }

        function nextStep() {
            if (state.currentStep < 7) {
                document.querySelector(`.diag-step[data-step="${state.currentStep}"]`).classList.remove('active');
                state.currentStep++;
                document.querySelector(`.diag-step[data-step="${state.currentStep}"]`).classList.add('active');
                updateProgress();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function prevStep() {
            if (state.currentStep > 1) {
                document.querySelector(`.diag-step[data-step="${state.currentStep}"]`).classList.remove('active');
                state.currentStep--;
                document.querySelector(`.diag-step[data-step="${state.currentStep}"]`).classList.add('active');
                updateProgress();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function selectOption(key, value, autoAdvance) {
            state.responses[key] = value;
            
            // UI Update
            const cards = document.querySelector(`.diag-step[data-step="${state.currentStep}"]`).querySelectorAll('.diag-option-card');
            cards.forEach(card => {
                if (card.querySelector('.diag-option-text').innerText === value) {
                    card.classList.add('selected');
                } else {
                    card.classList.remove('selected');
                }
            });

            if (autoAdvance) {
                setTimeout(nextStep, 350);
            }
        }

        function toggleMultiOption(key, value) {
            const index = state.responses[key].indexOf(value);
            if (index > -1) {
                state.responses[key].splice(index, 1);
            } else {
                state.responses[key].push(value);
            }

            // UI Update
            const cards = document.querySelector(`.diag-step[data-step="${state.currentStep}"]`).querySelectorAll('.diag-option-card');
            cards.forEach(card => {
                if (card.querySelector('.diag-option-text').innerText === value) {
                    card.classList.toggle('selected');
                }
            });
        }

        function toggleWhatsapp() {
            state.responses.whatsapp = state.responses.whatsapp === 1 ? 0 : 1;
            document.getElementById('diag_whatsapp_checkbox').classList.toggle('checked');
        }

        function submitDiagnostic() {
            state.responses.nom = document.getElementById('diag_nom').value;
            state.responses.prenom = document.getElementById('diag_prenom').value;
            state.responses.adresse = document.getElementById('diag_adresse').value;
            state.responses.telephone = document.getElementById('diag_tel').value;

            if (!state.responses.nom || !state.responses.telephone) {
                alert("Veuillez renseigner au moins votre nom et votre téléphone.");
                return;
            }

            const btn = document.getElementById('diag-submit-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Envoi en cours...';

            const formData = new FormData();
            formData.append('action', 'submit_diagnostic');
            for (const key in state.responses) {
                if (Array.isArray(state.responses[key])) {
                    formData.append(key, JSON.stringify(state.responses[key]));
                } else {
                    formData.append(key, state.responses[key]);
                }
            }

            // Using current page URL for post
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(async r => {
                const text = await r.text();
                try {
                    return JSON.parse(text);
                } catch(e) {
                    console.error("Non-JSON response:", text);
                    throw new Error("La réponse du serveur n'est pas valide.");
                }
            })
            .then(data => {
                if (data.status === 'success') {
                    nextStep();
                } else {
                    console.error("Submission Error:", data.message);
                    alert("Erreur lors de l'enregistrement: " + data.message);
                    btn.disabled = false;
                    btn.innerHTML = 'Finaliser mon diagnostic';
                }
            })
            .catch(err => {
                console.error("Fetch Error:", err);
                alert("Une erreur de communication est survenue: " + err.message);
                btn.disabled = false;
                btn.innerHTML = 'Finaliser mon diagnostic';
            });
        }

        // Initialize progress
        updateProgress();
    </script>
</body>
</html>
