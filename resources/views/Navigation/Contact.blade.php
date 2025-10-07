<x-layout>
    <x-slot:title>Contact - CodeQuest</x-slot:title>

    <h1 class="display-4">Contact Us</h1>
    <p class="lead">Get in touch with the CodeQuest team.</p>
    
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
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Your name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="your.email@example.com">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" rows="4" placeholder="Your message..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</x-layout>