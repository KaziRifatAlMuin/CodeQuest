<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Contact - CodeQuest <?php $__env->endSlot(); ?>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-envelope" style="color: var(--success);"></i> Contact Us
            </h1>
            <p class="lead">Get in touch with the CodeQuest team.</p>
        </div>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title">Contact Information</h2>
            <ul class="list-unstyled mt-3">
                <li class="mb-3"><strong>📧 Email:</strong> support@codequest.com</li>
                <li class="mb-3"><strong>💬 Discord:</strong> discord.gg/codequest</li>
                <li class="mb-3"><strong>🐦 Twitter:</strong> @codequestapp</li>
                <li class="mb-3"><strong>💼 GitHub:</strong> github.com/codequest</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title">Send Us a Message</h2>

            <!-- Alert placeholders -->
            <div id="contactAlert" class="alert d-none" role="alert" aria-live="polite"></div>

            <form id="contactForm" action="https://api.web3forms.com/submit" method="POST" class="mt-3">
                <input type="hidden" name="access_key" value="51d312ac-2af3-4467-bdbb-634e254da658">

                <div class="mb-3">
                    <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Your Name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Your Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Your Email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Subject" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Your Message <span class="text-danger">*</span></label>
                    <textarea id="message" name="message" placeholder="Your Message" rows="5" class="form-control" required></textarea>
                </div>

                <!-- Honeypot spam protection (hidden) -->
                <div class="d-none" aria-hidden="true">
                    <input type="checkbox" name="botcheck" tabindex="-1" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>

            <script>
                // Minimal client-side handling to show success/error using Bootstrap alert classes
                (function () {
                    var form = document.getElementById('contactForm');
                    var alertBox = document.getElementById('contactAlert');

                    form.addEventListener('submit', function (e) {
                        // Let the form submit to web3forms; show a loading state
                        alertBox.className = 'alert alert-info';
                        alertBox.textContent = 'Sending...';
                        alertBox.classList.remove('d-none');
                    });

                    // If using AJAX you'd intercept submit and POST via fetch, then show success/error.
                    // For simplicity we allow normal POST which will navigate away on success.
                })();
            </script>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/navigation/contact.blade.php ENDPATH**/ ?>