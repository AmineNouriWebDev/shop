# DASHBOARD_PLAN.md — Plan de modernisation de l'admin
> Fichier de mémoire persistante. Mis à jour à chaque fin de phase.

---

## ✅ PHASE 0 — Audit & Inventaire TERMINÉE

---

## 📁 Structure du dossier `_admin_site/`

```
_admin_site/
├── index.php              (975 lignes — routeur principal via switch($_GET['r']))
├── login.php              (7319 octets — page de connexion)
├── logout.php             (minuscule — destroy session + redirect)
├── arrays.php             (5779 octets — DataTable server-side produits)
├── arrays_commandes.php   (4858 octets — DataTable server-side commandes)
├── assets/
│   ├── images/            (images statiques admin)
│   └── plugins/           (Bootstrap, jQuery, DataTables, Select2, etc.)
├── css/
│   ├── style.css          (161 Ko — thème MaterialAdmin)
│   ├── colors/blue.css    (thème de couleur actif)
│   ├── animate.css
│   ├── material.css
│   └── spinners.css
├── js/
│   ├── custom.min.js
│   ├── sidebarmenu.js
│   ├── waves.js
│   └── jquery.slimscroll.js
├── scss/                  (sources SCSS du thème, non utilisées en production)
├── includes/
│   ├── header.php         (topbar Bootstrap — logo + toggle)
│   ├── left.php           (sidebar gauche — nav complète)
│   ├── footer.php         (footer minimaliste : 1 ligne)
│   ├── scripts.php        (CSS head : Bootstrap, FA, DataTables, CKEditor)
│   ├── scripts_footer.php (JS footer : jQuery, Bootstrap, DataTables, CKEditor, Select2)
│   ├── include.php        (charge connec.php + fction_db + functions + fction_admins)
│   ├── security.php       (vérification session admin)
│   ├── topbar.php
│   ├── home.php           (vide ou simple)
│   ├── messages.php       (liste messages contact)
│   ├── commandes.php      (DataTable commandes)
│   ├── produits.php       (DataTable produits)
│   ├── client.php         (liste clients)
│   └── fonctions/         (23 fichiers de fonctions métier)
│       ├── fction_db.php      → executeRequete(), afficheChamp()
│       ├── fction_commandes.php → CRUD commandes
│       ├── fction_clients.php   → CRUD clients
│       ├── fction_produits.php  → CRUD produits, marques, catégories
│       ├── fction_messages.php  → supprimerMessage()
│       └── functions.php        → timstamptodate(), nomClt(), prenomClt()
```

---

## 🗃️ Tables de la base de données — Dashboard

| Table                    | Description                                          | Champs clés                                            |
|--------------------------|------------------------------------------------------|--------------------------------------------------------|
| `commandes`              | Commandes clients                                    | `id`, `idclient`, `nom`, `prenom`, `email`, `total`, `sous_total`, `etat`, `date`, `moyen_paiement` |
| `ligne_commande`         | Lignes de commandes (produits)                       | `id`, `idcommande`, `id_produit`, `quantite`           |
| `clients`                | Clients inscrits                                     | `id`, `nom`, `prenom`, `email`, `tel`, `date_inscription`, `etat` |
| `produits`               | Catalogue produits                                   | `id`, `titre`, `prix_vente`, `prix_promo`, `photo`, `categorie`, `marque`, `etat`, `datecreation` |
| `etat_commandes`         | États possibles de commandes                         | `id`, `etat`                                           |
| `messages`               | Messages formulaire de contact                       | `id`, `nom`, `prenom`, `email`, `sujet`, `message`, `date`, `lu` |
| `moyens_paiement`        | Moyens de paiement disponibles                       | `id`, `moyen`                                          |
| `marques`                | Marques produits                                     | `id`, `raison`, `link`, `photo`                        |

---

## 🎨 Librairies CSS/JS actuellement utilisées dans l'admin

### CSS (chargés dans `scripts.php`)
| Librairie                           | Rôle                                |
|-------------------------------------|-------------------------------------|
| Bootstrap 4 (local)                 | Layout, grille, composants          |
| MaterialAdmin `style.css` (161 Ko)  | Thème complet admin (sidebar, topbar, cards) |
| Font Awesome 4.7 (CDN)              | Icônes                              |
| Material Design Icones (MDI)        | Icônes sidebar (`mdi-*`)            |
| DataTables CSS (local)              | Tables avec boutons export          |
| CKEditor 5 CSS (CDN)                | Éditeur riche                       |
| Select2 CSS (local)                 | Selects améliorés                   |
| animate.css, spinners.css (local)   | Animations, preloader               |

### JS (chargés dans `scripts_footer.php`)
| Librairie                           | Rôle                                |
|-------------------------------------|-------------------------------------|
| jQuery (local)                      | Manipulation DOM                    |
| Bootstrap JS + Popper (local)       | Composants Bootstrap                |
| DataTables (local)                  | Tables server-side, export          |
| slimscroll, waves, sidebarmenu (local) | Sidebar comportement             |
| CKEditor 5 (CDN module)             | Éditeur riche pages/articles        |
| Select2 (local)                     | Selects améliorés                   |
| Bootstrap Datepicker (local)        | Sélecteur de dates                  |
| Moment.js (local)                   | Manipulation dates                  |

---

## 🏗️ Système de layout actuel

```
index.php
 ├── <head>
 │    └── include("includes/scripts.php")  ← tous les CSS
 ├── <body>
 │    ├── #preloader (SVG spinner)
 │    ├── #main-wrapper
 │    │    ├── include("includes/header.php")  ← topbar
 │    │    ├── include("includes/left.php")    ← sidebar gauche
 │    │    └── .page-wrapper
 │    │         ├── .row.page-titles (breadcrumb)
 │    │         └── .container-fluid
 │    │              └── switch($_GET['r']) → include page spécifique
 │    └── include("includes/footer.php")
 └── include("includes/scripts_footer.php") ← tous les JS
```

---

## 📊 Requêtes SQL utiles pour le Dashboard

### KPI Cards
```sql
-- Total commandes
SELECT COUNT(*) FROM commandes;
-- Commandes aujourd'hui
SELECT COUNT(*) FROM commandes WHERE DATE(FROM_UNIXTIME(date)) = CURDATE();
-- CA du mois
SELECT SUM(total) FROM commandes WHERE MONTH(FROM_UNIXTIME(date)) = MONTH(CURDATE()) AND YEAR(FROM_UNIXTIME(date)) = YEAR(CURDATE());
-- Produits actifs
SELECT COUNT(*) FROM produits WHERE etat = 1;
-- Clients inscrits
SELECT COUNT(*) FROM clients WHERE etat = 1;
-- Messages non lus
SELECT COUNT(*) FROM messages;  -- (champ `lu` à vérifier)
```

### Dernières commandes (Bloc B)
```sql
SELECT c.id, c.nom, c.prenom, c.email, c.total, c.etat, c.date,
       ec.etat as libelle_etat
FROM commandes c
LEFT JOIN etat_commandes ec ON ec.id = c.etat
ORDER BY c.date DESC LIMIT 10;
```

### Derniers messages (Bloc C)
```sql
SELECT id, nom, prenom, email, sujet, message, date FROM messages ORDER BY date DESC LIMIT 5;
```

### Top produits vendus (Bloc D)
```sql
SELECT p.id, p.titre, p.photo, SUM(lc.quantite) as qte_vendue,
       SUM(lc.quantite * p.prix_vente) as revenu
FROM ligne_commande lc
JOIN produits p ON p.id = lc.id_produit
GROUP BY lc.id_produit ORDER BY qte_vendue DESC LIMIT 5;
```

### Graphique commandes 30 jours (Bloc E)
```sql
SELECT DATE(FROM_UNIXTIME(date)) as jour, COUNT(*) as nb, SUM(total) as ca
FROM commandes
WHERE date >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 DAY))
GROUP BY jour ORDER BY jour ASC;
```

### Répartition par statut (Bloc E)
```sql
SELECT ec.etat, COUNT(c.id) as nb
FROM commandes c
LEFT JOIN etat_commandes ec ON ec.id = c.etat
GROUP BY c.etat;
```

---

## ⚙️ Configuration npm/Tailwind

- **Tailwind version** : 4.2.1 via `@tailwindcss/cli`
- **Tailwind config** (`tailwind.config.js`) : déjà configuré pour scanner `_admin_site/**/*.php` ✅
- **Scripts npm existants** :
  - `npm run dev` → watch frontend public
  - `npm run build` → build frontend public
- **CSS source frontend** : `dist/css/tailwind.css`
- **CSS compilé frontend** : `dist/css/tailwind.output.css`

---

## 🎨 Palette de couleurs actuelle (Tailwind public)
```js
primary:   #5A31F4 (violet tech)
secondary: #0EA5E9 (cyan)
accent:    #F43F5E (rouge CTA)
success:   #10B981
warning:   #F59E0B
error:     #EF4444
```

---

## 🗺️ Feuille de route

| Phase | Description                              | Statut  |
|-------|------------------------------------------|---------|
| 0     | Audit & Inventaire                       | ✅ Done  |
| 1     | Infrastructure Tailwind Admin            | ⬜ Todo  |
| 2     | Refonte Layout (Sidebar + Header)        | ⬜ Todo  |
| 3     | Dashboard Homepage (index.php)           | ⬜ Todo  |
| 4     | Performance & Optimisation               | ⬜ Todo  |
| 5     | Dark Mode Admin                          | ⬜ Todo  |
| 6     | Polish & Détails UX                      | ⬜ Todo  |

---

## 🔮 Décisions à prendre avant Phase 1

### 1. Librairie d'icônes pour la nouvelle sidebar
| Option | Avantages | Inconvénients |
|--------|-----------|---------------|
| **Heroicons** (SVG inline) | Zero dépendance, Tailwind-friendly, 292 icônes, moderne | Un peu verbeux en PHP |
| **Lucide** (npm + bundler) | 1400+ icônes, cohérent, très populaire | Nécessite config bundler |
| **Phosphor Icons** (CDN CSS) | 9000+ icônes, classes CSS simples | CDN externe, poids |

### 2. Palette de couleurs pour l'admin
| Option | Description |
|--------|-------------|
| **A — Dark Sidebar** | Sidebar sombre (`#1E1B4B` violet foncé) + content blanc — look admin classique moderne |
| **B — Full Dark Mode** | Interface toute sombre dès le départ — look très technique |
| **C — Réutilisation palette public** | Sidebar violet primaire `#5A31F4`, cohérence avec le site public |

### 3. CSS source admin
- Créer `_admin_site/assets/css/admin.css` comme source Tailwind dédiée
- Ajouter scripts npm `build:admin` et `watch:admin` dans `package.json`

---

## 📝 Notes techniques importantes

1. **Le `tailwind.config.js` existe à la racine** et inclut déjà `_admin_site/**/*.php` — pas besoin de modifier le content scanning
2. **Le layout repose sur des `require/include` PHP** — on modifie uniquement `header.php`, `left.php`, `footer.php`, `scripts.php`, `scripts_footer.php`
3. **La logique métier ne doit PAS être touchée** — uniquement le HTML/CSS/JS de présentation
4. **DataTables est déjà intégré en server-side** pour les produits et commandes
5. **Le champ `date` dans `commandes` est un timestamp Unix** (nécessite `FROM_UNIXTIME()`)
6. **Les endpoints JSON** seront dans `_admin_site/api/` (nouveau dossier à créer)
7. **Tailwind v4** est utilisé (`@tailwindcss/cli`) — syntaxe légèrement différente de v3

---
*Dernière mise à jour : Phase 0 terminée — 2026-03-05*
