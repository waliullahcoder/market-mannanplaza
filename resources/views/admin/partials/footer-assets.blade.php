<!-- All Jquery -->
{{-- <script
    src="{{ asset('public/elite-admin/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
--}}

<!-- Jquery for multi select or choose -->
<script src="{{ asset('/public/elite-admin/dist/js/chosen.jquery.js') }}"></script>

{{-- Page Plugins --}}
<script src="{{ asset('public/elite-admin/assets/node_modules/select2/dist/js/select2.full.min.js') }}"
    type="text/javascript"></script>

<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('public/elite-admin/assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('public/elite-admin/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- tagsinput JS -->
<script src="{{ asset('public/elite-admin/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}">
</script>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('public/elite-admin/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>

<!--Wave Effects -->
<script src="{{ asset('public/elite-admin/dist/js/waves.js') }}"></script>

<!--Menu sidebar -->
<script src="{{ asset('public/elite-admin/dist/js/sidebarmenu.js') }}"></script>

<!--stickey kit -->
<script src="{{ asset('public/elite-admin/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('public/elite-admin/assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Sweet-Alert  -->
<script src="{{ asset('/public/elite-admin/assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('/public/elite-admin/assets/node_modules/sweetalert/jquery.sweet-alert.custom.js') }}"></script>

<!--Custom JavaScript -->
<script src="{{ asset('public/elite-admin/dist/js/custom.min.js') }}"></script>

<!-- switchery  -->
<script src="{{ asset('/public/elite-admin/assets/node_modules/switchery/dist/switchery.min.js') }}"></script>

<!-- summernote  -->
<script src="{{ asset('/public/elite-admin/assets/node_modules/summernote/dist/summernote.min.js') }}"></script>

<!-- Summernote with Bootstrap 4  -->
<script src="{{ asset('/public/elite-admin/summernote/summernote-bs4.js') }}"></script>

<script src="{{ asset('/public/elite-admin/js/tinymce/tinymce.min.js') }}"></script>

<!-- This is data table -->
<script src="{{ asset('public/elite-admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
{{-- <script
    src="{{ asset('public/elite-admi/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}">
</script> --}}

<!-- jQuery peity -->
<script src="{{ asset('public/elite-admin/assets/node_modules/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('public/elite-admin/assets/node_modules/peity/jquery.peity.init.js') }}"></script>

<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('public/elite-admin/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}">
</script>


<script src="{{ asset('public/elite-admin/dist/plugin/enlarge/bod-modal.js') }}">
</script>


<script>
    function removeFromArrayByValue(arr) {
        var what, a = arguments,
            L = a.length,
            ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax = arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }


    $(function() {

        $(".add_datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            format: 'dd-mm-yyyy',
        }).datepicker('setDate', 'today');

        $('.add_datepicker').datepicker().on('changeDate', function(ev) {
            $('.add_datepicker').datepicker('hide');
        });

        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);

        $(".from_date").datepicker({
            format: 'dd-mm-yyyy',
            changeMonth: true,
            changeYear: true,
        });
        $(".from_date").datepicker("setDate", firstDay);

        $('.from_date').datepicker().on('changeDate', function(ev) {
            $('.from_date').datepicker('hide');
        });

        $(".to_date").datepicker({
            format: 'dd-mm-yyyy',
            changeMonth: true,
            changeYear: true,
        });
        $(".to_date").datepicker("setDate", 'today');

        $('.to_date').datepicker().on('changeDate', function(ev) {
            $('.to_date').datepicker('hide');
        });

        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            format: 'dd-mm-yyyy',
        });

        $('.datepicker').datepicker().on('changeDate', function(ev) {
            $('.datepicker').datepicker('hide');
        });
    });

    $('input[id=tags]').tagsinput();
    $('.bootstrap-tagsinput input[type=text]').on('keydown', function(e) {
        if (event.which == 13) {
            $(this).blur();
            $(this).focus();
            return false;
        }
    });

    $(document).ready(function() {
        setTimeout(function() {
            //$(".message").hide('blind', {}, 500));
            $(".message").slideUp(1000).hide(1000);
        }, 5000);

        tinymce.init({
            selector: '.tinymce',
            forced_root_block: ''
        });

        $(".chosen-select").chosen({
            search_contains: true
        });

        // For select 2
        $(".select2").select2({
                allowClear: true,
            });
        // $('.selectpicker').selectpicker();

        // For Print Jquery Code
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });

        // This is for the sticky sidebar
        $(".stickyside").stick_in_parent({
            offset_top: 100
        });

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });

        var table = $('#dataTable').DataTable({
            pageLength: 20,
            "order": [
                [0, "asc"]
            ]
        });

        var dtb = $('#dtb').DataTable({
            pageLength: 20,
        });

        // table.on('order.dt search.dt', function () {
        //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();

        // $('[data-toggle="tooltip"]').tooltip();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



    });

</script>


<!-- This is Tree Menu JS  -->
<script src="{{ asset('public/tree-menu/TreeMenu.js') }}"></script>
