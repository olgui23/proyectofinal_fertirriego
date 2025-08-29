<footer class="footer py-4 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-lg-4 text-lg-start">
                Copyright &copy; Fertirriego {{ date('Y') }}
            </div>
            <div class="col-lg-4 my-3 my-lg-0">
                @php
                $socialLinks = [
                    ['icon' => 'fab fa-twitter', 'url' => '#', 'label' => 'Twitter'],
                    ['icon' => 'fab fa-facebook-f', 'url' => '#', 'label' => 'Facebook'],
                    ['icon' => 'fab fa-linkedin-in', 'url' => '#', 'label' => 'LinkedIn']
                ];
                @endphp
                
                @foreach($socialLinks as $social)
                <a class="btn btn-outline-light btn-social mx-2" 
                   href="{{ $social['url'] }}" 
                   aria-label="{{ $social['label'] }}">
                    <i class="{{ $social['icon'] }}"></i>
                </a>
                @endforeach
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="link-light text-decoration-none me-3" href="#">Política de Privacidad</a>
                <a class="link-light text-decoration-none" href="#">Términos de Uso</a>
            </div>
        </div>
    </div>
</footer>