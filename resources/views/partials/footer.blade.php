<footer class="bg-base-200 text-base-content  pt-10 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- 1. Company Info -->
            <div>
                <h2 class="text-2xl font-bold mb-3">
                    <img src="{{asset('assets/images/logo_noveden.png')}}" alt="logo noveden" class="max-w-[300px] h-auto">
                </h2>
                <p class="mb-4">
                    Inspirés de l’Éden, nos soins 100 % naturels sont
                    formulés à partir de plantes ayurvédiques, fruits et légumes pour nourrir, fortifier
                    et sublimer naturellement les cheveux et la peau.
                </p>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span>📧</span>
                        <span>Email: {{app(\App\Settings\GeneralSetting::class)->email}}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📞</span>
                        <span>Tel: {{app(\App\Settings\GeneralSetting::class)->phoneNumber}}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <span>Adresse: {{app(\App\Settings\GeneralSetting::class)->address}}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>✅</span>
                        <span>Numéro d'entreprise: {{app(\App\Settings\GeneralSetting::class)->companyNumber}}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Liens légaux -->
            <div>
                <h3 class="footer-title">Liens légaux </h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="link link-hover" href="#">Mentions légales</a></li>
                    <li><a class="link link-hover" href="#">Politique de confidentialité</a></li>
                    <li><a class="link link-hover" href="#">Politique de remboursement</a></li>
                    <li><a class="link link-hover" href="#">Politique livraison</a></li>
                    <li><a class="link link-hover" href="#">Conditions générales d'utilisation</a></li>
                </ul>
            </div>

            <!-- 3. Liens de navigation -->
            <div>
                <h3 class="footer-title">Accueil</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="link link-hover" href="#">Acceuil</a></li>
                    <li><a class="link link-hover" href="#">Blog</a></li>
                    <li><a class="link link-hover" href="#">FAQ</a></li>
                    <li><a class="link link-hover" href="#">Contact</a></li>
                    <li><a class="link link-hover" href="#">Suivi de commande</a></li>
                    <li><a class="link link-hover" href="{{url('/admin')}}">Administration</a></li>
                </ul>
            </div>

            <!-- 4. Réseaux sociaux & promo -->
            <div>
                <h3 class="footer-title">Suivez-nous</h3>
                <div class="flex gap-4 text-xl mt-2">
                    <a href="{{app(\App\Settings\GeneralSetting::class)->facebookUrl}}" class="hover:text-primary"> @svg('icon-facebook','w-6 h-6') </a>
                    <a href="{{whatsappUrl()}}" class="hover:text-primary">@svg('icon-whatsapp','w-6 h-6')</a>
                    <a href="{{app(\App\Settings\GeneralSetting::class)->instagramUrl}}" class="hover:text-primary">@svg('icon-instagram','w-6 h-6')</a>
                    <a href="{{app(\App\Settings\GeneralSetting::class)->twitterUrl}}" class="hover:text-primary">@svg('icon-twitter','w-6 h-6')</a>
                </div>
                <div class="mt-4 bg-primary text-white p-3 rounded-md text-sm">
                    🎁 10% de réduction sur votre première commande !
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="mt-10 border-t border-base-300 pt-6 text-sm">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <p class="text-center lg:text-left">
                    © 2025, {{app(\App\Settings\GeneralSetting::class)->name}} Powered by
                    <a class="link text-primary" href="{{config('project.powered_by.link')}}" target="_blank">{{config('project.powered_by.company_name')}}</a> •
                    <a href="#" class="link link-hover">Politique de confidentialité</a> •
                    <a href="#" class="link link-hover">Conditions d'utilisation</a> •
                    <a href="#" class="link link-hover">Politique d'expédition</a>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-end gap-2 text-xs">
                    <span class="badge badge-outline">Visa</span>
                    <span class="badge badge-outline">Mastercard</span>
                    <span class="badge badge-outline">PayPal</span>
                    <span class="badge badge-outline">Apple Pay</span>
                    <span class="badge badge-outline">Google Pay</span>
                </div>
            </div>
        </div>
    </div>
</footer>
