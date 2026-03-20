    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../media/site/<?php echo $favicon; ?>">
    <!-- Google Fonts — Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind Admin CSS (compilé) -->
    <link href="assets/css/admin.output.css" rel="stylesheet">
    <!-- Bootstrap Core CSS (conservé pour les composants DataTables, CKEditor, Select2) -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <!-- Popup CSS -->
    <link href="../assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <!-- html5 editor -->
    <link rel="stylesheet" href="../assets/plugins/html5-editor/bootstrap-wysihtml5.css" />
    
    <link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables/css/buttons.dataTables.min.css" />
    
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/ckeditor5-premium-features.css">
    
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

            <script type="textt/javascript">

                    $('#Type').on('change', function() {    
                        if(this.value == "A") {
                            $('#selectAbonnement').show();
                        } else {
                            $('#selectAbonnement').hide();
                        }
                        
                    });
            </script>  
            
<script type="text/javascript">
    function ShowHideDiv() {
        var Type = document.getElementById("Type");
        var selectAbonnement = document.getElementById("selectAbonnement");
        selectAbonnement.style.display = Type.value == "A" ? "block" : "none";
    }
</script>

<style>
.ck-editor__editable {min-height: 300px;}

/* ── Admin Inputs — styles garantis hors compilation Tailwind ── */
.admin-input,
.admin-select {
    display: block;
    width: 100%;
    padding: 0.625rem 0.875rem;
    font-size: 0.875rem;
    line-height: 1.5;
    color: var(--color-text-primary, #120b2e);
    background-color: #ffffff;
    border: 1px solid var(--color-border, #D1C8F0) !important;
    border-radius: 0.5rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.admin-input:focus,
.admin-select:focus {
    border-color: var(--color-primary, #5a31f4) !important;
    outline: 0;
    box-shadow: 0 0 0 3px rgba(90, 49, 244, 0.12);
}
html.dark .admin-input,
html.dark .admin-select {
    color: var(--color-text-primary-dark, #EDE9FF);
    background-color: #1c1930;
    border-color: var(--color-border-dark, #3F376F) !important;
}
</style>

<!-- Anti-FOUC script for Dark Mode -->
<script>
    if (localStorage.getItem('admin_dark_mode') === '1') {
        document.documentElement.classList.add('dark');
    }
</script>
<style>
/* -- Sidebar nav text colors fix -- */
.admin-nav-item-text,
.admin-nav-item { color: var(--color-sidebar-text, #a89fc5) !important; text-decoration: none; }
.admin-subnav-item { color: var(--color-sidebar-text, #a89fc5) !important; text-decoration: none; }
.admin-nav-item:hover .admin-nav-item-text,
.admin-nav-item:hover { color: var(--color-sidebar-text-hover, #fff) !important; }
.admin-subnav-item:hover { color: #fff !important; }
.admin-nav-item.active, .admin-nav-item.active .admin-nav-item-text { color: #fff !important; }

/* -- Commandes action icons -- */
.action-buttons { display: flex; align-items: center; gap: 6px; }
.action-btn { display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 6px; text-decoration: none;
    transition: all 0.15s; flex-shrink: 0; }
.action-btn svg { width: 15px; height: 15px; }
.view-btn { background: rgba(90,49,244,0.08); color: var(--color-primary, #5a31f4); }
.view-btn:hover { background: var(--color-primary, #5a31f4); color: #fff; }
.delete-btn { background: rgba(239,68,68,0.08); color: #ef4444; }
.delete-btn:hover { background: #ef4444; color: #fff; }
</style>

