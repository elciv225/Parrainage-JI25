<?php

echo "Page du questionnaire";

?>



<div class="quiz-container">
    <header class="quiz-header">
        <nav class="quiz-nav">
            <?php if (2 > 0): ?>
                <button class="back-btn">←</button>
            <?php else: ?>
                <div></div>
            <?php endif; ?>

            <div>
                <div class="quiz-title">Aptitude Test</div>
                <div class="question-counter">Question <?php echo 2 + 1; ?>
                    of <?php echo 5 ?></div>
            </div>
            <div class="back-button">
                <a href="#inscription" class="btn-back">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Sortir
                </a>
            </div>
        </nav>
        <div class="progress-bar" style="--total-questions: 5"></div>
    </header>

    <main class="quiz-content">
        <div class="questions-wrapper">
            <div class="questions-slider">
                <div class="question-item">
                    <h2 class="question">
                        Tu aimes le Paiya
                    </h2>

                    <div class="options">
                        <button class="option" data-index="1">
                            Non
                        </button>
                        <button class="option" data-index="1">
                            Oui
                        </button>
                        <button class="option" data-index="1">
                            Oui Beaucoup
                        </button>
                        <button class="option" data-index="1">
                            Oui, mais pas souvent
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="quiz-footer">
        <button class="next-btn" disabled>Next →</button>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const options = document.querySelectorAll('.option');
        const nextBtn = document.querySelector('.next-btn');

        options.forEach(option => {
            option.addEventListener('click', function () {
                // Remove selected class from all options
                options.forEach(opt => opt.classList.remove('selected'));
                // Add selected class to clicked option
                this.classList.add('selected');
                // Enable next button
                nextBtn.disabled = false;
            });
        });

        nextBtn.addEventListener('click', function () {
            // Here you would typically submit the answer and load the next question
            // This would involve making an AJAX request or form submission to PHP
        });
    });
</script>
