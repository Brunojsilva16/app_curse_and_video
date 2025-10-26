<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div id="forgotContainer" class="w-full max-w-sm bg-white p-6 rounded shadow-2xl transition-opacity duration-700 ease-in-out">
        
        <div class="flex flex-col items-center mb-6">
            <img src="<?= BASE_URL ?>/assets/img/conecta_free.png" alt="Logo" class="h-12 w-12 mb-2">
            <h1 class="text-3xl font-bold text-gray-800">Redefinir Senha</h1>
            <p class="text-sm text-gray-600 mt-2 text-center">Informe seu email para receber o link de redefinição.</p>
        </div>

        <div id="msg" class="mb-4 text-sm text-center"></div>

        <form id="formForgotPassword" class="space-y-6">
            
            <div>
                <label class="block text-sm font-medium sr-only">Email</label>
                <div class="relative">
                    <input type="email" name="email" class="w-full border-b-2 border-gray-300 p-2 pl-10 focus:border-indigo-600 focus:outline-none placeholder-gray-500" placeholder="Seu email" required>
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26c.72.48 1.61.48 2.33 0L21 8m-2 10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v11z"></path></svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition duration-150">
                Enviar Link
            </button>
            
            <div class="text-center pt-2">
                <a href="<?= BASE_URL ?>/login" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    Voltar para o Login
                </a>
            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('formForgotPassword').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const msgDiv = document.getElementById('msg');
    const submitButton = form.querySelector('button[type="submit"]');

    // Feedback visual imediato
    msgDiv.textContent = 'Enviando solicitação...';
    msgDiv.className = "mb-4 text-gray-600 text-center";
    submitButton.disabled = true;

    try {
        const response = await fetch('esqueci-a-senha', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        
        // O resultado será TRUE mesmo se o email não existir (segurança)
        if (result.success) {
            msgDiv.textContent = result.message;
            msgDiv.className = "mb-4 text-green-600 text-center";
            form.elements['email'].value = ''; 
        } else {
            msgDiv.textContent = result.message;
            msgDiv.className = "mb-4 text-red-600 text-center";
        }
    } catch (error) {
        msgDiv.textContent = "Erro de rede. Tente novamente.";
        msgDiv.className = "mb-4 text-red-600 text-center";
    } finally {
        submitButton.disabled = false;
    }
});
</script>