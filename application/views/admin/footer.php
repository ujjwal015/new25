  <!-- <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container"><span>&copy; 2020 <a
                        href="http://themeforest.net/user/pixinvent/portfolio?ref=pixinvent"
                        target="_blank">PIXINVENT</a> All rights reserved.</span><span
                    class="right hide-on-small-only">Design and Developed by <a
                        href="https://pixinvent.com/">PIXINVENT</a></span></div>
        </div>
    </footer> -->

    <!-- END: Footer-->
    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url('master_assets/admin/') ?>js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    
    <!-- BEGIN THEME  JS-->
    <script src="<?= base_url('master_assets/admin/') ?>js/plugins.js"></script>
    <script src="<?= base_url('master_assets/admin/') ?>js/search.js"></script>
    <script src="<?= base_url('master_assets/admin/') ?>js/custom/custom-script.js"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- <script src="<?= base_url('master_assets/admin/') ?>js/scripts/dashboard-ecommerce.js"></script> -->
    <!-- END PAGE LEVEL JS-->

    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?= base_url('master_assets/admin/') ?>vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('master_assets/admin/') ?>vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('master_assets/admin/') ?>vendors/data-tables/js/dataTables.select.min.js"></script>
    <!-- END PAGE VENDOR JS-->

    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?= base_url('master_assets/admin/') ?>js/scripts/data-tables.js"></script>
    <!-- END PAGE LEVEL JS-->

    <script>
        $('#slide-out li').click(function(){
           $(this).addClass('active').siblings().removeClass('active'); 
        });
    </script>
</body>

</html>