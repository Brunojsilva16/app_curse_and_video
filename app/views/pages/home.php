<?php if (!empty($courses) && is_array($courses)) : ?>
    <div class="courses-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php foreach ($courses as $course) : ?>
            <?php
            $defaultImage = BASE_URL . '/assets/img/default_course.svg';
            $imageUrl = $defaultImage; // Valor Padrão

            // Verifica se a URL da imagem não está vazia E se o arquivo físico existe no servidor
            if (!empty($course['image_url']) && file_exists(ROOT_PATH . '/public' . $course['image_url'])) {
                $imageUrl = BASE_URL . htmlspecialchars($course['image_url']);
            }
            ?>
            <div class="course-card bg-white rounded-lg shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300 flex flex-col">
                <a href="<?= BASE_URL ?>/curso/<?= $course['id'] ?>" class="block">
                    <img src="<?= $imageUrl ?>" alt="Capa do curso <?= htmlspecialchars($course['title']) ?>" class="w-full h-48 object-cover">
                </a>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="relative">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 h-20 pr-20"><?= htmlspecialchars($course['title']) ?></h3>
                        <span class="absolute top-0 right-0 text-xs font-semibold px-2 py-1 rounded-full category-<?= strtolower($course['category']) ?>"><?= ucfirst($course['category']) ?></span>
                    </div>

                    <div class="text-sm text-gray-500 mb-4">
                        <span class="font-semibold"><?= htmlspecialchars($course['workload'] ?? 'N/A') ?>h</span>
                    </div>
                    <div class="mt-auto">
                        <?php if ($course['status'] === 'published') : ?>
                            <p class="text-xl font-semibold text-indigo-600 mb-4">
                                <?php if (!empty($course['price']) && $course['price'] > 0) : ?>
                                    R$ <?= htmlspecialchars(number_format($course['price'], 2, ',', '.')) ?>
                                <?php else : ?>
                                    Gratuito
                                <?php endif; ?>
                            </p>
                            <a href="<?= BASE_URL ?>/curso/<?= $course['id'] ?>" class="block text-center bg-gradient-to-r from-indigo-500 to-blue-600 text-white py-2 rounded-lg font-semibold hover:from-indigo-600 hover:to-blue-700 transition duration-150">
                                Ver Detalhes
                            </a>
                        <?php else : ?>
                            <p class="text-md font-semibold text-red-500 mb-4">Indisponível</p>
                            <button disabled class="w-full text-center bg-gray-300 text-gray-600 py-2 rounded-lg font-semibold cursor-not-allowed">
                                Indisponível
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else : ?>
    <!-- Mensagem de fallback se não houver cursos -->
    <div class="text-center py-12 bg-gray-50 rounded-lg">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.467 9.5 5 8 5a2.5 2.5 0 00-2.5 2.5c0 .356.126.702.355 1.011l.732 1.026a3.5 3.5 0 00-.73 3.633l-.75.75A1 1 0 004 15.5V17a1 1 0 001 1h14a1 1 0 001-1v-1.5a1 1 0 00-.205-.623l-.75-.75a3.5 3.5 0 00-.73-3.633l.732-1.026c.229-.309.355-.655.355-1.011A2.5 2.5 0 0016 5c-1.5 0-2.832.467-4 1.253z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum Curso Disponível</h3>
        <p class="mt-1 text-sm text-gray-500">Volte mais tarde para conferir nossos lançamentos!</p>
    </div>
<?php endif; ?>
