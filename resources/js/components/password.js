function togglePassword(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector("i");

    if (!field) return;

    const isHidden = field.type === "password";

    field.type = isHidden ? "text" : "password";

    icon.classList.toggle("bi-eye", !isHidden);
    icon.classList.toggle("bi-eye-slash", isHidden);
}

window.togglePassword = togglePassword;
