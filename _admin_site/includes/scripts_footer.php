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
