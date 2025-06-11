    <!-- Material Design JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        // Initialize Material Design components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dropdowns
            var dropdowns = document.querySelectorAll('.dropdown-trigger');
            M.Dropdown.init(dropdowns);
            
            // Initialize selects
            var selects = document.querySelectorAll('select');
            M.FormSelect.init(selects);
            
            // Initialize modals
            var modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);
        });
    </script>
</body>
</html>