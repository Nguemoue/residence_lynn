<footer class="bg-base-200 text-base-content pt-10 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- 1. À propos -->
            <div>
                <h2 class="text-2xl font-bold mb-3">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo hébergement Kribi" class="max-w-[200px] h-auto">
                </h2>
                <p class="mb-4 text-sm">
                    Découvrez Kribi autrement. Nous vous proposons une sélection de studios, chambres et appartements pour un séjour tout confort au bord de l'océan.
                </p>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span>📧</span>
                        <span>Email: {{ app(\App\Settings\GeneralSetting::class)->email }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📞</span>
                        <span>Tél: {{ app(\App\Settings\GeneralSetting::class)->phoneNumber }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <span>Adresse: {{ app(\App\Settings\GeneralSetting::class)->address }}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Informations utiles -->
            <div>
                <h3 class="footer-title">Informations</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="link link-hover" href="#">Mentions légales</a></li>
                    <li><a class="link link-hover" href="#">Politique de confidentialité</a></li>
                    <li><a class="link link-hover" href="#">Conditions générales</a></li>
                    <li><a class="link link-hover" href="#">Politique d’annulation</a></li>
                    <li><a class="link link-hover" href="#">Politique de remboursement</a></li>
                </ul>
            </div>

            <!-- 3. Navigation rapide -->
            <div>
                <h3 class="footer-title">Navigation</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="link link-hover" href="{{ url('/') }}">Accueil</a></li>
                    <li><a class="link link-hover" href="#accommodations">Nos logements</a></li>
                    <li><a class="link link-hover" href="#gallery">Galerie</a></li>
                    <li><a class="link link-hover" href="#faq">FAQ</a></li>
                    <li><a class="link link-hover" href="#contact">Contact</a></li>
                    <li><a class="link link-hover" href="{{ url('/admin') }}">Espace Admin</a></li>
                </ul>
            </div>

            <!-- 4. Réseaux sociaux & Promo -->
            <div>
                <h3 class="footer-title">Suivez-nous</h3>
                <div class="flex gap-4 text-xl mt-2">
                    <a href="{{ app(\App\Settings\GeneralSetting::class)->facebookUrl }}" class="hover:text-primary">@svg('icon-facebook','w-6 h-6')</a>
                    <a href="{{ whatsappUrl() }}" class="hover:text-primary">@svg('icon-whatsapp','w-6 h-6')</a>
                    <a href="{{ app(\App\Settings\GeneralSetting::class)->instagramUrl }}" class="hover:text-primary">@svg('icon-instagram','w-6 h-6')</a>
                </div>
                <div class="mt-4 bg-primary text-white p-3 rounded-md text-sm">
                    🎁 5% de réduction sur votre première réservation avec le code <b>K-RIBI5</b> !
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="mt-10 border-t border-base-300 pt-6 text-sm">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <p class="text-center lg:text-left">
                    © {{ now()->year }}, {{ app(\App\Settings\GeneralSetting::class)->name }}. Tous droits réservés.
                    Propulsé par <a class="link text-primary" href="{{ config('project.powered_by.link') }}" target="_blank">{{ config('project.powered_by.company_name') }}</a>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-end gap-2 text-xs">
                    <span class="badge badge-outline">Visa</span>
                    <span class="badge badge-outline">Mastercard</span>
                    <span class="badge badge-outline">PayPal</span>
                    <span class="badge badge-outline">MTN Mobile Money</span>
                    <span class="badge badge-outline">Orange Money</span>
                </div>
            </div>
        </div>
    </div>
</footer>
