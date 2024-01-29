document.addEventListener("DOMContentLoaded", function() {
    // Function to enable editing
    function enableEdit() {
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].removeAttribute("disabled");
        }
        document.getElementById("editButton").style.display = "none";
        document.getElementById("saveButton").style.display = "inline-block";

        // Set the id_edit value in the form (provide the desired value)
        var idEditField = document.getElementById("id_edit");
        var idEditValue = ""; // Set your desired value here
        idEditField.value = idEditValue;
    }

    // Trigger enableEdit function when needed, e.g., by clicking a button
    const editButton = document.getElementById("editButton");
    if (editButton) {
        editButton.addEventListener("click", function() {
            enableEdit();
        });
    }

    // Toggle password visibility
    const passwordField = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    if (passwordField && togglePassword) {
        togglePassword.addEventListener("click", function() {
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
            this.querySelector("i").classList.toggle("bi-eye");
            this.querySelector("i").classList.toggle("bi-eye-slash");
        });
    }
});
