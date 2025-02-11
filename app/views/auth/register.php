<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - YouEvent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.svg">
    <script src="../../../public/assets/scripts/register.js"></script>

</head>
<style>
    .selected-role {
    border-color: black !important;
    color: black !important;
    font-weight: bold;
}

</style>

<body>
    
    <section
        class="hero bg-orange-500/5 h-screen flex-grow flex justify-center items-center border-orange-400 bg-opacity-20 bg-[url('../../../public/assets/images/loginbg.jpg')] bg-cover bg-center">
        <div class="bg-white/10 backdrop-blur-lg rounded-lg p-8 md:shadow-lg w-full max-w-md">
            <h2 class="text-white text-center text-3xl font-semibold mb-6">Inscription</h2>
            <form method="post" id="registerForm" enctype="multipart/form-data">
                <div class="relative mb-4">
                    <i class="ri-user-line text-gray-100 absolute left-4 top-2.5 text-xl"></i>
                    <input type="text" placeholder="Nom d'utilisateur" name="username" required
                        class="w-full pl-12 pr-4 py-2 border border-gray-100 rounded-lg bg-white/10 text-black placeholder-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" />
                </div>

                <div class="relative mb-4">
                    <i class="ri-mail-line text-gray-100 absolute left-4 top-2.5 text-xl"></i>
                    <input type="email" placeholder="Email" name="email" required
                        class="w-full pl-12 pr-4 py-2 border border-gray-100 rounded-lg bg-white/10 text-black placeholder-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" />
                </div>

                <!-- Sélection du rôle -->
                <div class="mb-6 w-full">
                    <label class="block text-white font-semibold mb-2">Choisissez votre rôle :</label>
                    <div class="flex justify-center space-x-4 w-full">
                        <label
                            class="role-option flex items-center justify-center w-1/2 border border-gray-100 rounded-lg cursor-pointer text-gray-100 bg-transparent hover:border-black hover:text-black focus:ring focus:ring-orange-400 transition">
                            <input type="radio" name="role" value="Participant" class="hidden radio-input" />
                            <span class="font-medium">Participant</span>
                        </label>
                        <label
                            class="role-option flex items-center justify-center w-1/2 py-3 border border-gray-100 rounded-lg cursor-pointer text-gray-100 bg-transparent hover:border-black hover:text-black focus:ring focus:ring-orange-400 transition">
                            <input type="radio" name="role" value="Organisateur" class="hidden radio-input" />
                            <span class="font-medium">Organisateur</span>
                        </label>
                    </div>
                </div>

                <div class="relative mb-4">
                    <i class="ri-lock-line text-gray-100 absolute left-4 top-2.5 text-xl"></i>
                    <input type="password" placeholder="Mot de passe" name="password" required id="password"
                        class="w-full pl-12 pr-4 py-2 border border-gray-100 rounded-lg bg-white/10 text-black placeholder-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" />
                </div>

                <div class="relative mb-6">
                    <i class="ri-lock-line text-gray-100 absolute left-4 top-2.5 text-xl"></i>
                    <input type="password" placeholder="Confirmez le mot de passe" name="confirm_password"
                        id="confirm_password" required
                        class="w-full pl-12 pr-4 py-2 border border-gray-100 rounded-lg bg-white/10 text-black placeholder-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" />
                </div>

                <button type="submit" name="submit"
                    class="w-full py-2 bg-orange-400 text-white font-semibold rounded-lg transition duration-200 hover:bg-white hover:border hover:border-orange-400 hover:text-orange-400">
                    S'inscrire
                </button>

                <div class="errorsContainer">
                    <?php if (!empty($error)): ?>
                        <p class="text-red-600 text-center mt-4"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                </div>
            </form>

            <p class="text-center text-gray-100 mt-4">
                Vous avez déjà un compte ?
                <a href="./login.php" class="text-white hover:underline">Connexion</a>
            </p>
        </div>
    </section>

</body>

</html>