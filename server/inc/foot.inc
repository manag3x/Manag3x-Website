
    <!-- END MAIN CONTAINER -->
    <?php 
        if($page_type != "auth" AND $page_type != "error" AND $page_type != "guest")
            require_once("footnote.inc");
        require_once("foot_script.inc");
    ?>
    <script>
        checkall('todoAll', 'todochkbox');
        $('[data-toggle="tooltip"]').tooltip()
    </script>
</body>
</html>