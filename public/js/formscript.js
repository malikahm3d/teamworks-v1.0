// const tinymce = require("tinymce");
tinymce.init({
    selector: '#PostBody',
    protect: [
        /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
        /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
        /<\?php.*?\?>/g, // Protect php code
    ],
    valid_elements : 'a[href|target=_blank],strong/b,div[align],br'
});
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        //TODO: more advanced from checking with individual error messages
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
