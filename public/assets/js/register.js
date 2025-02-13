document.addEventListener("DOMContentLoaded", function () {
    const roleOptions = document.querySelectorAll(".role-option");
    const form = document.getElementById("registerForm");
    const username = document.querySelector("input[name='username']");
    const email = document.querySelector("input[name='email']");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");
    const roleInputs = document.querySelectorAll("input[name='role']");
    const errorContainer = document.querySelector(".errorsContainer");
  
    roleOptions.forEach((option) => {
      option.addEventListener("click", function () {
        roleOptions.forEach((el) => el.classList.remove("selected-role"));
        this.classList.add("selected-role");
        this.querySelector("input").checked = true;
      });
    });
  
    form.addEventListener("submit", function (event) {
      let errors = [];
  
      if (!username.value.trim()) errors.push("Le nom d'utilisateur est requis.");
      if (!email.value.trim()) errors.push("L'email est requis.");
      if (!password.value.trim()) errors.push("Le mot de passe est requis.");
      if (!confirmPassword.value.trim())
        errors.push("Veuillez confirmer votre mot de passe.");
  
      const roleSelected = Array.from(roleInputs).some((option) => option.checked);
      if (!roleSelected) errors.push("Veuillez choisir un rôle.");
  
      if (password.value !== confirmPassword.value) {
        errors.push("Les mots de passe ne correspondent pas.");
      }
  
      if (password.value.length < 6) {
        errors.push("Le mot de passe doit contenir au moins 6 caractères.");
      }
  
      if (errors.length > 0) {
        event.preventDefault();
        errorContainer.innerHTML = errors
          .map(
            (error) =>
              `<p class="text-white bg-red-600 p-2 font-semibold mt-4 rounded-md text-center text-sm">${error}</p>`
          )
          .join("");
      } else {
        errorContainer.innerHTML = "";
      }
    });
  });
  