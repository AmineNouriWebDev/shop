    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!-- This is data table -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    
    <script src="../assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables/js/buttons.print.min.js"></script>
    
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--ckeditor -->
     <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>

        <script type="importmap">
            {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/",
                    "ckeditor5-premium-features": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/ckeditor5-premium-features.js",
                    "ckeditor5-premium-features/": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/"
                }
            }
        </script>
        <script type="module">
            // This sample still does not showcase all CKEditor 5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            import {
                ClassicEditor,
                Autoformat,
                Bold,
                Italic,
                Underline,
                BlockQuote,
                Base64UploadAdapter,
                CloudServices,
                CKBox,
                CKBoxImageEdit,
                Essentials,
                FindAndReplace,
                Font,
                Heading,
                Image,
                ImageCaption,
                ImageResize,
                ImageStyle,
                ImageToolbar,
                ImageUpload,
                PictureEditing,
                Indent,
                IndentBlock,
                Link,
                List,
                MediaEmbed,
                Mention,
                Paragraph,
                PasteFromOffice,
                SourceEditing,
                Table,
                TableColumnResize,
                TableToolbar,
                TextTransformation,
                HtmlEmbed,
                CodeBlock,
                RemoveFormat,
                Code,
                SpecialCharacters,
                HorizontalLine,
                PageBreak,
                TodoList,
                Strikethrough,
                Subscript,
                Superscript,
                Highlight,
                Alignment
            } from 'ckeditor5';

            import {
                ExportPdf,
                ExportWord
            } from 'ckeditor5-premium-features';

            const createEditor = ( selector ) => {
                const element = document.querySelector( selector );
                if ( !element ) {
                    return;
                }

                ClassicEditor.create( element, {
                    plugins: [
                        Autoformat,
                        BlockQuote,
                        Bold,
                        CloudServices,
                        CKBox,
                        Essentials,
                        FindAndReplace,
                        Font,
                        Heading,
                        Image,
                        ImageCaption,
                        ImageResize,
                        ImageStyle,
                        ImageToolbar,
                        ImageUpload,
                        Base64UploadAdapter,
                        Indent,
                        IndentBlock,
                        Italic,
                        Link,
                        List,
                        MediaEmbed,
                        Mention,
                        Paragraph,
                        PasteFromOffice,
                        PictureEditing,
                        SourceEditing,
                        Table,
                        TableColumnResize,
                        TableToolbar,
                        TextTransformation,
                        Underline,
                        HtmlEmbed,
                        CodeBlock,
                        RemoveFormat,
                        Code,
                        SpecialCharacters,
                        HorizontalLine,
                        PageBreak,
                        TodoList,
                        Strikethrough,
                        Subscript,
                        Superscript,
                        Highlight,
                        Alignment,
                        CKBoxImageEdit,
                        ExportPdf,
                        ExportWord
                    ],
                    toolbar: {
                        items: [
                            'undo', 'redo',
                            '|',
                            'sourceEditing',
                            '|',
                            'exportPDF','exportWord',
                            '|',
                            'findAndReplace', 'selectAll',
                            '|',
                            'heading',
                            '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor',
                            '-',
                            'bold', 'italic', 'underline',
                            {
                                label: 'Formatting',
                                icon: 'text',
                                items: [ 'strikethrough', 'subscript', 'superscript', 'code', '|', 'removeFormat' ]
                            },
                            '|',
                            'specialCharacters', 'horizontalLine', 'pageBreak',
                            '|',
                            'link', 'insertImage', 'ckbox', 'ckboxImageEdit', 'insertTable',
                            {
                                label: 'Insert',
                                icon: 'plus',
                                items: [ 'highlight', 'blockQuote', 'mediaEmbed', 'codeBlock', 'htmlEmbed' ]
                            },
                            'alignment',
                            '|',
                            'bulletedList', 'numberedList', 'todoList',
                            {
                                label: 'Indents',
                                icon: 'plus',
                                items: [ 'outdent', 'indent' ]
                            }
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                        ]
                    },
                    placeholder: '',
                    image: {
                        resizeOptions: [
                            {
                                name: 'resizeImage:original',
                                label: 'Default image width',
                                value: null
                            },
                            {
                                name: 'resizeImage:50',
                                label: '50% page width',
                                value: '50'
                            },
                            {
                                name: 'resizeImage:75',
                                label: '75% page width',
                                value: '75'
                            }
                        ],
                        toolbar: [
                            'imageTextAlternative',
                            'toggleImageCaption',
                            '|',
                            'imageStyle:inline',
                            'imageStyle:wrapText',
                            'imageStyle:breakText',
                            '|',
                            'resizeImage'
                        ],
                    },
                    link: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://'
                    },
                    table: {
                        contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ],
                    },
                    ckbox: {
                        tokenUrl: 'https://api.ckbox.io/token/demo',
                        theme: 'lark'
                    }
                } )
                .then( ( editor ) => {
                    window.editor = editor;
                } )
                .catch( ( error ) => {
                    console.error( error.stack );
                } );
            };

            createEditor( '#editor1' );
            createEditor( '#editor2' );
            createEditor( '#editor3' );
            createEditor( '#editor4' );
            createEditor( '#editor5' );
            createEditor( '#editor6' );
            

        </script>

    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    
    <script src="../assets/plugins/moment/moment.js"></script>
    <script src="../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.fr.js"></script>
    <script src="../assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    
    <script>
        jQuery(document).ready(function() {
            // For select 2
            $(".select2").select2({
                placeholder:"-- Séléctionnez --"
            });
        });
    </script>
    
	
    <script>

        function getCaracteristique() {
            
            var opt =  $("#mySelect2").val();
            
                //alert(opt);
                
                $.ajax({
        
                  type: "POST",
        
                  url: "includes/get_caracteristique.php?id=<?php echo isset($_GET['id']) ? intval($_GET['id']) : 0; ?>",
        
                  data:'id_carac='+opt,
        
                  success: function(data){
        
                    $("#list-carac").html(data);
        
                  }

                });
        }
        
        jQuery(document).ready(function() {
            
            var opt =  $("#mySelect2").val();
            
                //alert(opt);
                
                $.ajax({
        
                  type: "POST",
        
                  url: "includes/get_caracteristique.php?id=<?php echo isset($_GET['id']) ? intval($_GET['id']) : 0; ?>",
        
                  data:'id_carac='+opt,
        
                  success: function(data){
        
                    $("#list-carac").html(data);
        
                  }

                });
            
        });

    </script>
    <script>
    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker({
    format: 'dd/mm/yyyy',
	language: 'fr'
   });
    </script>
    <!-- Magnific popup JavaScript -->
    <script src="../assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="../assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    
    <!-- wysuhtml5 Plugin JavaScript -->
    <script src="../assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
    <script src="../assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>
    
    <script>
    $(document).ready(function() {

        $('.textarea_editor').wysihtml5();


    });
    </script>
			<script>
				$(document).ready(function() {
				    $('#tableG').DataTable();
					$('#tableCmd').DataTable({
					    "lengthChange": true,
                    	"processing": true,
                    	"serverSide": true,
                        "searching": true,
                    	"serverMethod": 'post',
                        "order": [1, 'desc'],
                    	'ajax': {
                    	    url: 'arrays_commandes.php',
                            type: 'POST',
                            data: function(data) {
                                data.idclient = $('#idclient_filter').val();
                            }
                    	},
                        "columns": [
                            { "data": "" },
                            { "data": "id" },
                            { "data": "num" },
                            { "data": "client" },
                            { "data": "montant" },
                            { "data": "etat" },
                            { "data": "action" }
                        ],
					    "columnDefs": [
					        {
					            "targets": 0,
					            "orderable": false
					        },
					        {
					            "targets": 1,
					            "visible": false
					        }
					    ]
					});

					$('#checkAllCmd').on('change', function () {
					    $('.sub_chk_cmd').prop('checked', $(this).is(':checked'));
					});

					$('.delete_all_cmd').on('click', function () {
					    var allVals = [];
					    $('.sub_chk_cmd:checked').each(function () {
					        allVals.push($(this).attr('data-id'));
					    });
					    if (allVals.length === 0) {
					        alert('Veuillez s\u00e9lectionner au moins une commande.');
					        return;
					    }
					    if (!confirm('\u00cates-vous s\u00fbr de vouloir supprimer les ' + allVals.length + ' commande(s) s\u00e9lectionn\u00e9e(s) ?\nCette action est irr\u00e9versible.')) {
					        return;
					    }
					    $.ajax({
					        type: 'POST',
					        url: 'index.php?r=commandes',
					        data: { action_cmd: 'supp_multiple', ids: allVals.join(',') },
					        success: function () {
					            window.location.reload();
					        },
					        error: function () {
					            alert('Erreur lors de la suppression.');
					        }
					    });
					});

					window.confirmDeleteCmd = function(id) {
					    if (!confirm('\u00cates-vous s\u00fbr de vouloir supprimer cette commande ?\nCette action est irr\u00e9versible.')) {
					        return;
					    }
					    $.ajax({
					        type: 'POST',
					        url: 'index.php?r=commandes',
					        data: { action_cmd: 'supp_multiple', ids: id },
					        success: function () {
					            window.location.reload();
					        },
					        error: function () {
					            alert('Erreur lors de la suppression.');
					        }
					    });
					};
					$(document).ready(function() {
                
                        var strt = '<?php if(isset($_GET['start']) && $_GET['start'] != '') echo intval($_GET['start']); else echo '0';  ?>';
						
						var table = $('#tableProduit').DataTable({
                    		"lengthChange": true,
                    		"processing":true,
                    		"serverSide":true,	
                    		'serverMethod': 'post',
                    		'searching': false,	
                    		"order":[],
                            "displayStart": strt,
                    		'ajax': {
                    		    url:'arrays.php',
                                type: 'POST',
                    		    dataType: 'json',
                                'data': function(data){
                                    // Read values
                                    var titre = $('#searchByTitle').val();
                                    var categorie = $('#searchByCateg').val();
                                    var marque = $('#searchByMarque').val();
                                    
                                  
                                    // Append to data
                                    data.searchByTitle = titre;
                                    data.searchByCateg = categorie;
                                    data.searchByMarque = marque;
                                    if(strt){
                                
                                        document.getElementById('startValue').value = strt;
                                        
                                    }else{
                                  
                                        document.getElementById('startValue').value = data.start;
                                    }
                                }
                    		},
                            'columns': [
                                { "data": "" },
                                { "data": "produit" },
                                { "data": "prix_vente" },
                                { "data": "categorie" },
                                { "data": "marque" },
                                { "data": "type" },
                                { "data": "datecreation" },
                                { "data": "action" }
                            ]
                            
						});
                          $('#searchByTitle').keyup(function(){
                            table.draw();
                          });
                          $('#searchByCateg').keyup(function(){
                            table.draw();
                          });
                          $('#searchByMarque').keyup(function(){
                            table.draw();
                          });
                        
                          $('#searchByTitle').onpaste = function(){
                            table.draw();
                          };
                          $('#searchByCateg').onpaste = function(){
                            table.draw();
                          };
                          $('#searchByMarque').onpaste = function(){
                            table.draw();
                          };
					});
					$('.delete_all').on('click', function(e) { 
                        var allVals = [];  
                        $(".sub_chk:checked").each(function() {  
                          allVals.push($(this).attr('data-id'));
                        });  
                        //alert(allVals.length); return false;  
                        if(allVals.length ==0)  
                        {  
                          alert("Veuillez sélectionner le produit.");  
                        }  
                        else {  
                          //$("#loading").show(); 
                          WRN_PROFILE_DELETE = "Etes-vous sur de vouloir supprimer la sélection de produits ?";  
                          var check = confirm(WRN_PROFILE_DELETE);  
                          if(check == true){  
                            //for server side
                            
                            var join_selected_values = allVals.join(","); 
                            //alert(join_selected_values)
                            
                            $.ajax({   
                              
                              type: "POST",  
                              url: "includes/deleteIdProduits.php",  
                              cache:false,  
                              data: 'ids='+join_selected_values,  
                              success: function(response)  
                              {   
                                window.location.reload();
                              }   
                            });
                            /*      //for client side
                            $.each(allVals, function( index, value ) {
                              $('table tr').filter("[data-row-id='" + value + "']").remove();
                            });*/
                            
                          }  
                        }  
                    });
				});
			</script>
			<script type="text/javascript">
					$(document).ready(function(){
						selected();
						function selected(){
						var parents = document.getElementsByClassName("select-parent");
                        if (parents.length > 0) {
                            var x = parents[0].id;
			$('.select-parent > option[value= '+x+'] ').attr('selected',true);
                        }
					}
				});
			</script>

<!-- ============================================================
     ADMIN JS — Sidebar, Dropdowns, Dark Mode
     ============================================================ -->
<script>
(function() {
    'use strict';

    /* ─── DARK MODE ─────────────────────────────────────────── */
    var DARK_KEY = 'admin_dark_mode';

    function applyDark(dark) {
        if (dark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem(DARK_KEY, '1');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem(DARK_KEY, '0');
        }
    }

    // Appliquer le thème sauvegardé dès le chargement
    var savedDark = localStorage.getItem(DARK_KEY);
    if (savedDark === '1') {
        document.documentElement.classList.add('dark');
    }

    window.toggleAdminDark = function() {
        document.documentElement.classList.add('admin-theme-transitioning');
        var isDark = document.documentElement.classList.contains('dark');
        applyDark(!isDark);
        setTimeout(function() {
            document.documentElement.classList.remove('admin-theme-transitioning');
        }, 300);
    };

    /* ─── SIDEBAR ────────────────────────────────────────────── */
    var sidebar   = document.getElementById('adminSidebar');
    var topbar    = document.getElementById('adminTopbar');
    var content   = document.getElementById('adminContent');
    var overlay   = document.getElementById('sidebarOverlay');
    var SIDEBAR_KEY = 'admin_sidebar_collapsed';

    // Desktop : état persisté
    var isCollapsed = localStorage.getItem(SIDEBAR_KEY) === '1';
    if (isCollapsed && window.innerWidth >= 1024) {
        sidebar  && sidebar.classList.add('collapsed');
        topbar   && topbar.classList.add('sidebar-collapsed');
        content  && content.classList.add('sidebar-collapsed');
    }

    window.toggleSidebar = function() {
        if (window.innerWidth < 1024) {
            // Mobile : off-canvas
            var isOpen = sidebar && sidebar.classList.contains('mobile-open');
            if (isOpen) {
                closeSidebar();
            } else {
                sidebar  && sidebar.classList.add('mobile-open');
                overlay  && overlay.classList.add('open');
            }
        } else {
            // Desktop : collapse
            var willCollapse = sidebar && !sidebar.classList.contains('collapsed');
            sidebar  && sidebar.classList.toggle('collapsed');
            topbar   && topbar.classList.toggle('sidebar-collapsed');
            content  && content.classList.toggle('sidebar-collapsed');
            localStorage.setItem(SIDEBAR_KEY, willCollapse ? '1' : '0');
        }
    };

    window.closeSidebar = function() {
        sidebar && sidebar.classList.remove('mobile-open');
        overlay && overlay.classList.remove('open');
    };

    // Resize : réajuster état sidebar
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar && sidebar.classList.remove('mobile-open');
            overlay && overlay.classList.remove('open');
        }
    });

    /* ─── SOUS-MENUS SIDEBAR ─────────────────────────────────── */
    window.toggleSubmenu = function(submenuId, btn) {
        var submenu = document.getElementById(submenuId);
        if (!submenu) return;
        var isOpen = submenu.classList.contains('open');

        // Fermer tous les autres sous-menus
        document.querySelectorAll('.admin-nav-submenu.open').forEach(function(el) {
            if (el.id !== submenuId) {
                el.classList.remove('open');
                var prevBtn = el.previousElementSibling;
                if (prevBtn) prevBtn.classList.remove('open');
            }
        });

        submenu.classList.toggle('open', !isOpen);
        if (btn) btn.classList.toggle('open', !isOpen);
    };

    /* ─── DROPDOWNS TOPBAR ───────────────────────────────────── */
    window.toggleDropdown = function(id) {
        var target = document.getElementById(id);
        if (!target) return;
        var isOpen = target.classList.contains('open');

        // Fermer tous les dropdowns
        document.querySelectorAll('.admin-dropdown.open').forEach(function(el) {
            el.classList.remove('open');
        });

        if (!isOpen) target.classList.add('open');
    };

    // Fermer les dropdowns au clic en dehors
    document.addEventListener('click', function(e) {
        var openDropdowns = document.querySelectorAll('.admin-dropdown.open');
        openDropdowns.forEach(function(dd) {
            if (!dd.parentElement.contains(e.target)) {
                dd.classList.remove('open');
            }
        });
    });

    /* ─── BADGES DYNAMIQUES (commandes + messages) ───────────── */
    function loadBadges() {
        // Charger les badges via un endpoint léger
        fetch('api/badges.php')
            .then(function(r) { return r.json(); })
            .then(function(data) {
                // Badge commandes
                var bcmd = document.getElementById('badge-commandes');
                if (bcmd && data.commandes > 0) {
                    bcmd.textContent = data.commandes;
                    bcmd.style.display = 'flex';
                }
                // Badge messages
                var bmsg = document.getElementById('badge-messages');
                if (bmsg && data.messages > 0) {
                    bmsg.textContent = data.messages;
                    bmsg.style.display = 'flex';
                }
                // Point de notification topbar
                var ndot = document.getElementById('notifDot');
                if (ndot && (data.commandes > 0 || data.messages > 0)) {
                    ndot.style.display = 'block';
                }
                // Aperçu notifications dropdown
                if (data.recent_commandes && data.recent_commandes.length > 0) {
                    var html = '';
                    data.recent_commandes.forEach(function(cmd) {
                        html += '<a href="index.php?r=dcommande&id=' + cmd.id + '" class="admin-dropdown-item" style="text-decoration:none;">'
                            + '<div style="width:32px;height:32px;border-radius:8px;background:rgba(90,49,244,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">'
                            + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;color:#5A31F4;"><path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25Z"/></svg>'
                            + '</div>'
                            + '<div style="flex:1;min-width:0;">'
                            + '<div style="font-size:0.8rem;font-weight:600;color:var(--color-text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">#' + cmd.id + ' — ' + (cmd.client || 'Client') + '</div>'
                            + '<div style="font-size:0.75rem;color:var(--color-text-muted);">' + cmd.total + ' TND · ' + cmd.date + '</div>'
                            + '</div></a>';
                    });
                    var notifList = document.getElementById('notifList');
                    if (notifList) notifList.innerHTML = html;
                }
            })
            .catch(function() { /* silencieux si l'API n'existe pas encore */ });
    }

    // Charger les badges au démarrage (si l'API existe)
    document.addEventListener('DOMContentLoaded', function() {
        loadBadges();
        // Actualiser toutes les 60 secondes
        setInterval(loadBadges, 60000);
    });

})();
</script>
