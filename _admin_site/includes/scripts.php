     <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../media/site/<?php echo $favicon; ?>">
   <!-- Bootstrap Core CSS --> 
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
</style>