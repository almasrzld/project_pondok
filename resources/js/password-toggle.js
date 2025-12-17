window.togglePassword = function (name) {
    const input = document.getElementById(name);
    const eye = document.getElementById(name + "-eye");
    const eyeSlash = document.getElementById(name + "-eye-slash");

    if (!input || !eye || !eyeSlash) return;

    const isPassword = input.type === "password";

    input.type = isPassword ? "text" : "password";
    eye.classList.toggle("hidden", !isPassword);
    eyeSlash.classList.toggle("hidden", isPassword);
};
