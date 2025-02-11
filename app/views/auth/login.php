<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - YouEvent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.svg">
</head>

<body>
    <section
        class="hero bg-orange-500/5 h-screen flex-grow flex justify-center items-center border-orange-400 bg-opacity-20 bg-[url('../../../public/assets/images/loginbg.jpg')]  bg-cover bg-center">
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-8 md:shadow-lg w-full max-w-md">
            <h2 class="text-white text-center text-3xl font-semibold mb-6">Se connecter</h2>

            <form method="post">
                <div class="relative mb-4">
                    <i class="ri-mail-line text-gray-100 absolute left-4 top-2 text-xl"></i>
                    <input type="email" placeholder="Email" name="email" required
                        class="w-full pl-12 pr-4 py-2 border border-gray-100 rounded-lg bg-white/10 text-gray-100 placeholder-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" />
                </div>

                <div class="relative mb-4">
                    <i class="ri-lock-line text-gray-100 absolute left-4 top-2 text-xl"></i>
                    <input type="password" placeholder="Mot de passe" name="password" required
                        class="w-full pl-12 border border-gray-100 pr-4 py-2 rounded-lg bg-white/10 text-gray-100 placeholder-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" />
                </div>

                <div class="flex justify-between text-white text-sm mb-6">
                    <label class="flex items-center text-gray-100">
                        <input type="checkbox" class="mr-2 black" />
                        Se souvenir de moi
                    </label>
                    <a href="#" class="hover:underline text-gray-100">Mot de passe oublié ?</a>
                </div>

                <button type="submit" name="submit"
                    class="w-full py-2 bg-white hover:bg-black text-orange-400 border-white font-semibold rounded-lg transition duration-200 hover:bg-white hover:border hover:border-orange-400 hover:text-orange-400 hover:text-black">
                    Connexion
                </button>

                <div class="errorsContainer">
                    <span class="flex justify-center text-center text-red-700 mb-5 mt-5">
                        <?php if (!empty($errorMessage)): ?>
                            <?= htmlspecialchars($errorMessage) ?>
                        <?php endif; ?>
                    </span>
                </div>
            </form>

            <p class="text-center text-gray-100  mt-4">
                Vous n'avez pas de compte ?
                <a href="./register.php" class="text-white hover:underline">Inscrivez-vous</a>
            </p>
        </div>
    </section>
</body>

</html>
