<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Code Core Solutions <?php echo date("Y"); ?> </div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<script src="./../admin/assets/js/jq.min.js"></script>


<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
<script src="./../admin/assets/js/bt.min.js" crossorigin="anonymous"></script>
<script src="assets/js/scripts.js"></script>
<!--//removed cdn links-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->

<!-- <script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script> -->
<script src="./../admin/assets/js/sdt.min.js" crossorigin="anonymous"></script>




<script src="assets/js/datatables-simple-demo.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="./../admin/assets/js/sl2.min.js"></script>

<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="./../admin/assets/js/swa.min.js"></script>


<!-- JSPDF CDN Link -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->
<script src="./../admin/assets/js/jspdf.umd.min.js"></script>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> -->
<script src="./../admin/assets/js/htmlcav.min.js"></script>

<!-- //JSPDF CDN Link -->

<!-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> -->
<script src="./../admin/assets/js/alrtfy.min.js"></script>
<script src="./../admin/assets/js/chart.js"></script>
<script src="assets/js/custom-scripts.js"></script>
<script src="assets/js/report-scripts.js"></script>
<script src="assets/js/DataTables/datatables.js"></script>
<script>
    $(document).ready( function () {
        $('#type-table').DataTable();
    } );

    $(document).ready( function () {
        $('#scrap-table').DataTable();
    } );

    $(document).ready( function () {
        $('#product-table').DataTable();
    });

    $(document).ready( function () {
        $('#orderstable').DataTable();   
    });

    $(document).ready( function () {
        $('#orderstable1').DataTable();   
    });

    $(document).ready(function() {
        $('.myselect2').select2();
    });
    
</script>
</body>

</html>