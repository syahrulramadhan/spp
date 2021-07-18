<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>LKPP | KEDEPUTIAN 4</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/offcanvas/">

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets/dist/css/bootstrap.css'); ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/jquery-ui.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('fontawesome-5.15.1/css/fontawesome.min.css');?>">
    <link href="<?= base_url('fontawesome-5.15.1/css/brands.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('fontawesome-5.15.1/css/solid.css'); ?>" rel="stylesheet">

    <link href="<?= base_url('css/select2.min.css'); ?>" rel="stylesheet" />
    <script src="<?= base_url('js/jquery-3.5.1.min.js'); ?>"></script>
    <script src="<?= base_url('js/jquery-ui.js'); ?>"></script>
    <script src="<?= base_url('js/select2.min.js'); ?>"></script>
    <script src="<?= base_url('js/jquery.mask.min.js'); ?>"></script>
    <script src="<?= base_url('assets/dist/js/bootstrap.bundle.js'); ?>"></script>
    <script src="<?= base_url('js/offcanvas.js') ?>"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
        
      /*
      .breadcrumb  .breadcrumb-item +  .breadcrumb-item::before { 
        content: ">";
      }
      */
      
      .breadcrumb{
        margin-top: 10px;
        margin-bottom: 5px;
      }

      #per_page{
        width: 65px;
        text-align: center;
      }

      .table thead th {
        vertical-align: middle;
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="<?= base_url('/css/offcanvas.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/css/style.css'); ?>" rel="stylesheet">
  </head>
  <body class="bg-light">
    
    <?= $this->include('layout/navbar'); ?>

    <div class="container">
      <div class="row">
        <div class="col-12">
          <?php /* $this->include('layout/breadcrumb'); */ ?>

          <?= $this->renderSection('content'); ?>
        </div>
      </div>
    </div>
    <script>
        $(document).ready(function() {
          $("#tanggal_pelaksanaan").datepicker({ dateFormat: 'dd-mm-yy' });
          $('#tanggal_pelaksanaan').mask('00-00-0000');
 
          submit_disable();

          $('#form-submit input[type=text], #form-submit input[type=password], #form-submit textarea').keyup(function() {
            submit_disable();
          });
        });
        
        function submit_disable(){
          var disable = true;

          var jumlah = 0;

          $('#form-submit input[type=text], #form-submit input[type=password], #form-submit input[type=file], #form-submit select option:selected, #form-submit textarea').each(function() {
              if($(this).val() === '' || $(this).val() === 0 || $(this).val() === '0') { 
                
              }else{
                //console.log($(this).val());

                jumlah = jumlah + 1;
              }
          });

          if(jumlah > 0)
            disable = false;

          $('#form-submit button[type="submit"]').prop('disabled', disable);
        }

        function number_format (number, decimals, dec_point, thousands_sep) {
          // Strip all characters but numerical ones.
          number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
          var n = !isFinite(+number) ? 0 : +number,
              prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
              sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
              dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
              s = '',
              toFixedFix = function (n, prec) {
                  var k = Math.pow(10, prec);
                  return '' + Math.round(n * k) / k;
              };
          // Fix for IE parseFloat(0.55).toFixed(0) = 0;
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
          if (s[0].length > 3) {
              s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
          }
          if ((s[1] || '').length < prec) {
              s[1] = s[1] || '';
              s[1] += new Array(prec - s[1].length + 1).join('0');
          }
          return s.join(dec);
      }
    </script>
  </body>
</html>
