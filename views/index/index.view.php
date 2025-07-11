<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DomoticLink</title>
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Swiper.js -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <!-- Tailwind CDN + plugins -->
  <!-- Google Font example -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet" />
  <!-- Font Awesome para íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <style>
    /* Estilos del Preloader */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #1a1a2e;
      /* Fondo oscuro */
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: opacity 0.75s ease, visibility 0.75s ease;
      visibility: visible;
      opacity: 1;
    }

    #preloader.hidden {
      opacity: 0;
      visibility: hidden;
    }

    .preloader-content {
      text-align: center;
    }

    .preloader-content .spinner {
      width: 80px;
      height: 80px;
      animation: spin 2s linear infinite;
      margin-bottom: 20px;
    }

    .preloader-content h1 {
      color: #ffffff;
      font-size: 24px;
      font-weight: 600;
      font-family: 'Montserrat', sans-serif;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* Dark Mode Styles */
    body.dark header nav {
      background: rgba(10, 10, 20, 0.9) !important;
      backdrop-filter: blur(5px);
    }

    body.dark .mobile-menu {
      background: rgba(10, 10, 20, 0.95) !important;
    }

    /* Estilos para el Panel de Control */
    .control-card {
      background: rgba(32, 38, 45, 0.8);
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      border: 1px solid #3f4d5a;
      color: #ffffff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .control-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .control-button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 15px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .control-button.active {
      background-color: #28a745;
      /* Verde cuando está activo */
    }

    .control-button:hover {
      background-color: #0056b3;
    }

    .control-button.active:hover {
      background-color: #218838;
    }
  </style>
  <link rel="stylesheet" href="public/css/estayls.css" />

  <!-- Estilos para el modelo 3D -->


  <!-- Icon -->
  <link rel="icon" href="publucimg/logo.jpg" />
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-image: linear-gradient(220.55deg, #eaeaea 0%, #8b8b8b 100%);
    }

    /* Altura fija del header para el scroll-margin */
    section {
      scroll-margin-top: 5rem;
    }

    #model-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      z-index: -1;
      pointer-events: none;
      overflow: hidden;
    }

    #model-container canvas {
      width: 100% !important;
      height: 100% !important;
      object-fit: contain;
    }

    /* Ajustes para móviles */
    @media (max-width: 768px) {
      #model-container {
        height: 50vh;
        /* Reducir altura en móviles */
        top: auto;
        bottom: 0;
      }

      /* Asegurar que el contenido no quede detrás del modelo en móviles */
      main {
        padding-bottom: 50vh;
        margin-top: 0;
      }

      /* Ajustar el espaciado del contenido principal */
      .section {
        padding-top: 2rem;
        padding-bottom: 2rem;
      }
    }

    /* Ajustes para tablets */
    @media (min-width: 769px) and (max-width: 1024px) {
      #model-container {
        height: 40vh;
      }

      main {
        padding-bottom: 40vh;
      }
    }


    /* Estilos para las partículas */
    #particles-js {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -1;
      pointer-events: none;
    }

    /* Contador de partículas (opcional) */
    .count-particles {
      position: absolute;
      top: 10px;
      left: 10px;
      color: #fff;
      font-size: 0.8em;
      font-family: Arial, Helvetica, sans-serif;
      pointer-events: none;
      z-index: 1000;
    }

    /* Estilos para el botón de menú móvil */
    #menu-button {
      display: none;
      /* Ocultar por defecto */
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 40px;
      height: 40px;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 0;
      z-index: 1001;
      position: relative;
    }

    #menu-button span {
      display: block;
      width: 24px;
      height: 2px;
      background-color: white;
      margin: 4px 0;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      transform-origin: center;
    }

    #menu-button.open span:first-child {
      transform: translateY(6px) rotate(45deg);
    }

    #menu-button.open span:nth-child(2) {
      opacity: 0;
      transform: scale(0);
    }

    #menu-button.open span:last-child {
      transform: translateY(-6px) rotate(-45deg);
    }

    /* Estilos para el menú móvil */
    #mobile-menu {
      position: fixed;
      top: 80px;
      /* Ajustado para que quede justo debajo del header fijo */
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #151a1e;
      z-index: 999;
      overflow-y: auto;
      padding: 20px;
      transform: translateX(-100%);
      transition: transform 0.3s ease-in-out;
    }

    #mobile-menu.active {
      transform: translateX(0);
      display: block;
    }

    /* Ocultar menú móvil en desktop */
    @media (min-width: 1024px) {
      #mobile-menu {
        display: none !important;
      }
    }

    #mobile-menu .max-w-md {
      margin: 0 auto;
      background: #1e252b;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    #mobile-menu a {
      display: block;
      padding: 12px 16px;
      color: white;
      text-decoration: none;
      font-size: 16px;
      font-weight: 500;
      transition: all 0.2s ease;
      border-radius: 8px;
      margin: 4px 0;
    }

    #mobile-menu a:hover {
      background-color: #2c363f;
    }

    /* Estilos para el modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1000;
      overflow-y: auto;
    }

    .modal-content {
      background-color: white;
      margin: 5% auto;
      padding: 2rem;
      border-radius: 8px;
      max-width: 500px;
      width: 90%;
      position: relative;
    }

    .dark .modal-content {
      background-color: #1e293b;
      color: white;
    }

    .close-modal {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 1.5rem;
      cursor: pointer;
    }

    /* Estilos para el toggle de modo oscuro */
    .checkbox-wrapper-54 input[type="checkbox"] {
      visibility: hidden;
      display: none;
    }

    .checkbox-wrapper-54 *,
    .checkbox-wrapper-54 ::after,
    .checkbox-wrapper-54 ::before {
      box-sizing: border-box;
    }

    .checkbox-wrapper-54 .switch {
      --width-of-switch: 3.5em;
      --height-of-switch: 2em;
      --size-of-icon: 1.4em;
      --slider-offset: 0.3em;
      position: relative;
      width: var(--width-of-switch);
      height: var(--height-of-switch);
      display: inline-block;
    }

    .checkbox-wrapper-54 .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #f4f4f5;
      transition: .4s;
      border-radius: 30px;
    }

    .dark .checkbox-wrapper-54 .slider {
      background-color: #374151;
    }

    .checkbox-wrapper-54 .slider:before {
      position: absolute;
      content: "";
      height: var(--size-of-icon, 1.4em);
      width: var(--size-of-icon, 1.4em);
      border-radius: 20px;
      left: var(--slider-offset, 0.3em);
      top: 50%;
      transform: translateY(-50%);
      background: linear-gradient(40deg, #ff0080, #ff8c00 70%);
      transition: .4s;
    }

    .checkbox-wrapper-54 input:checked+.slider {
      background-color: #303136;
    }

    .checkbox-wrapper-54 input:checked+.slider:before {
      left: calc(100% - (var(--size-of-icon, 1.4em) + var(--slider-offset, 0.3em)));
      background: #303136;
      box-shadow: inset -3px -2px 5px -2px #8983f7, inset -10px -4px 0 0 #a3dafb;
    }

    /* Media Queries */
    @media (max-width: 1023px) {
      #desktop-menu {
        display: none !important;
      }

      #menu-button {
        display: flex;
      }
    }

    @media (min-width: 1024px) {
      #mobile-menu {
        display: none !important;
      }
    }

    @media (min-width: 1025px) {
      #mobile-menu {
        display: none !important;
      }
    }

    /* Estilos para las nuevas secciones */
    .app-section,
    .virtual-tour-section {
      padding: 4rem 1rem;
      margin: 2rem 0;
      border-radius: 8px;
      background-color: rgba(255, 255, 255, 0.05);
    }

    .dark .app-section,
    .dark .virtual-tour-section {
      background-color: rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body class="text-gray-900" style="background: linear-gradient(114deg, rgba(43, 214, 255, 1) 0%, rgba(36, 179, 247, 1) 20%, rgba(0, 164, 244, 1) 40%, rgba(0, 138, 236, 1) 60%, rgba(0, 69, 180, 1) 80%);">
  <!-- Preloader -->
  <div id="preloader">
    <div class="preloader-content">
      <img src="public/image/logo.png" alt="Logo DomoticLink" class="spinner">
      <h1>DomoticLink</h1>
    </div>
  </div>
  <!-- Contenedor de partículas -->
  <div id="particles-js"></div>
  <!-- Contador de partículas (opcional) -->
  <!-- <div class="count-particles">
      <span class="js-count-particles">--</span> partículas
    </div -->


  <!-- NAV -->
  <header class="fixed top-0 inset-x-0 z-40" x-data="{open:false}">
    <nav class="flex items-center justify-between bg-gray-800/90 backdrop-blur px-4 lg:px-8 py-3 rounded-b-xl">

      <!-- Logo -->
      <a href="#" class="flex items-center gap-2">
        <div class="h-8 w-8">
          <img src="public/image/logo.png" alt="Logo DomoticLink" class="h-full w-full object-contain">
        </div>
        <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">DomoticLink</h2> <!-- Left menu -->
        <ul class="hidden lg:flex gap-6 text-gray-100 text-sm font-medium">
          <li><a href="#section1" class="ext-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors">Inicio</a></li>
          <li><a href="#section2" class="ext-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors">Nosotros</a></li>
          <li><a href="#section3" class="ext-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors">Servicios</a></li>
        </ul>



        <!-- Right menu -->
        <ul class="hidden lg:flex gap-6 text-gray-100 text-sm font-medium">
          <li><a href="#section4" class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors">¿Cómo Funciona?</a></li>
          <li><a href="#section5" class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors">Descargar App</a></li>
          <li><a href="#virtual-tour" class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors">Tour Virtual</a></li>
          <li><a href="#team" class="text-white text-sm font-medium leading-normal hover:text-blue-300 transition-colors">Nuestro Equipo</a></li>
        </ul>

        <!-- Actions -->
        <div class="hidden lg:flex items-center gap-4">
          <a href="#contact" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em]">
            <span class="truncate">Contáctanos</span>
          </a>
          <div class="flex items-center gap-2">
            <div class="checkbox-wrapper-54">
              <label class="switch">
                <input type="checkbox" id="darkModeToggle">
                <span class="slider"></span>
              </label>
            </div>
          </div>
        </div>

        <!-- Hamburger -->
        <button @click="open=!open" class="lg:hidden text-gray-100 focus:outline-none">
          <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
    </nav>
    <!-- Mobile menu -->
    <div x-show="open" x-transition class="lg:hidden bg-gray-800/95 text-gray-100 backdrop-blur p-6 space-y-4 mobile-menu">
      <a @click="open=false" href="#section1" class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors">Inicio</a>
      <a @click="open=false" href="#section2" class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors">Nosotros</a>
      <a @click="open=false" href="#section3" class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors">Servicios</a>
      <a @click="open=false" href="#section4" class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors">¿Cómo Funciona?</a>
      <a @click="open=false" href="#section5" class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors">Descargar App</a>
      <a @click="open=false" href="#team" class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors">Nuestro Equipo</a>
      <a @click="open=false" href="#virtual-tour" class="block py-3 px-4 text-white hover:bg-[#2c363f] rounded-lg transition-colors">Tour Virtual</a>
      <div class="pt-4">
        <a href="#contact" @click="open=false" class="block w-full text-center bg-[#dae5f0] text-[#151a1e] py-3 px-6 rounded-full font-bold text-sm hover:bg-opacity-90 transition-colors">
          Contáctanos
        </a>
      </div>
    </div>
  </header>
  <style>
    #model-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      z-index: -1;
      pointer-events: none;
    }

    #model-container canvas {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover;
    }
  </style>
  <!-- Contenedor modelo 3D -->
  <!-- 3D Scene on foreground -->
  <div id="model-container" class="fixed inset-0 z-10 pointer-events-none"></div>

  <!-- Contenido -->
  <main class="relative z-20 mt-40 max-w-5xl mx-auto px-4 space-y-20">
    <section id="section1" class="section space-y-4">
      <div class="@container">
        <div class="@[480px]:p-4">
          <div
            class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-center justify-center p-4"
            style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%)'>
            <div class="flex flex-col gap-2 text-center">
              <h1 id="home" class="text-dark text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] scroll-mt-20">
                Experimenta el Futuro de la Vivienda Inteligente
              </h1>
              <h2 class="text-dark text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">
                DomoticLink integra tecnología en tu hogar, proporcionando un control y comodidad sin precedentes. Explora nuestro tour interactivo del hogar con scrolling suave
                y animaciones dinámicas para descubrir cómo podemos transformar tu espacio de vida.
              </h2>
            </div>
            <button
              class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em]">
              <span class="truncate">Explorar Modelo 3D</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <section id="section2" class="section space-y-4">
      <h2 id="about" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">Acerca de</h2>
      <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
        En DomoticLink, estamos dedicados a revolucionar la forma en que vivimos en nuestros hogares a través de tecnología inteligente innovadora. Nuestra misión es crear entornos de hogar sin fisuras, intuitivos y seguros que mejoren la comodidad y la eficiencia. Con un equipo de expertos en tecnología y diseño, nos esforzamos por ofrecer soluciones que satisfagan las necesidades cambiantes de los propietarios de hogares modernos.
      </p>
    </section>

    <section id="section3" class="section space-y-4">
      <h2 id="services" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">Nuestros Servicios</h2>
      <div class="flex flex-col gap-10 px-4 py-10 @container">
        <div class="flex flex-col gap-4">
          <h1
            class="text-white tracking-light text-[32px] font-bold leading-tight @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] max-w-[720px]">
            Características de Hogar Inteligente
          </h1>
          <p class="text-white text-base font-normal leading-normal max-w-[720px]">
            DomoticLink ofrece una amplia gama de características diseñadas para mejorar tu experiencia de vida en el hogar. Desde iluminación automatizada hasta seguridad avanzada, tenemos todo cubierto.
          </p>
        </div>
        <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-0">
          <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
            <div class="text-white" data-icon="House" data-size="24px" data-weight="regular">
              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                <path
                  d="M218.83,103.77l-80-75.48a1.14,1.14,0,0,1-.11-.11,16,16,0,0,0-21.53,0l-.11.11L37.17,103.77A16,16,0,0,0,32,115.55V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V160h32v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V115.55A16,16,0,0,0,218.83,103.77ZM208,208H160V160a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v48H48V115.55l.11-.1L128,40l79.9,75.43.11.1Z"></path>
              </svg>
            </div>
            <div class="flex flex-col gap-1">
              <h2 class="text-white text-base font-bold leading-tight">Iluminación Inteligente</h2>
              <p class="text-[#a0adbb] text-sm font-normal leading-normal">Controla tus luces de forma remota, programa horarios y crea escenas de iluminación personalizadas.</p>
            </div>
          </div>
          <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
            <div class="text-white" data-icon="Lightbulb" data-size="24px" data-weight="regular">
              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                <path
                  d="M176,232a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,232Zm40-128a87.55,87.55,0,0,1-33.64,69.21A16.24,16.24,0,0,0,176,186v6a16,16,0,0,1-16,16H96a16,16,0,0,1-16-16v-6a16,16,0,0,0-6.23-12.66A87.59,87.59,0,0,1,40,104.49C39.74,56.83,78.26,17.14,125.88,16A88,88,0,0,1,216,104Zm-16,0a72,72,0,0,0-73.74-72c-39,.92-70.47,33.39-70.26,72.39a71.65,71.65,0,0,0,27.64,56.3A32,32,0,0,1,96,186v6h64v-6a32.15,32.15,0,0,1,12.47-25.35A71.65,71.65,0,0,0,200,104Zm-16.11-9.34a57.6,57.6,0,0,0-46.56-46.55,8,8,0,0,0-2.66,15.78c16.57,2.79,30.63,16.85,33.44,33.45A8,8,0,0,0,176,104a9,9,0,0,0,1.35-.11A8,8,0,0,0,183.89,94.66Z"></path>
              </svg>
            </div>
            <div class="flex flex-col gap-1">
              <h2 class="text-white text-base font-bold leading-tight">Gestión de Energía</h2>
              <p class="text-[#a0adbb] text-sm font-normal leading-normal">Monitorea y optimiza el consumo de energía para reducir costos e impacto ambiental.</p>
            </div>
          </div>
          <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
            <div class="text-white" data-icon="Lock" data-size="24px" data-weight="regular">
              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                <path
                  d="M208,80H176V56a48,48,0,0,0-96,0V80H48A16,16,0,0,0,32,96V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V96A16,16,0,0,0,208,80ZM96,56a32,32,0,1,1,32-32A32,32,0,0,1,96,56ZM208,208H48V96H208V208Zm-68-56a12,12,0,1,1-12-12A12,12,0,0,1,140,152Z"></path>
              </svg>
            </div>
            <div class="flex flex-col gap-1">
              <h2 class="text-white text-base font-bold leading-tight">Sistemas de Seguridad</h2>
              <p class="text-[#a0adbb] text-sm font-normal leading-normal">Protege tu hogar con cerraduras inteligentes, sensores de movimiento y alertas en tiempo real.</p>
            </div>
          </div>
          <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
            <div class="text-white" data-icon="Thermometer" data-size="24px" data-weight="regular">
              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                <path
                  d="M212,56a28,28,0,1,0,28,28A28,28,0,0,0,212,56Zm0,40a12,12,0,1,1,12-12A12,12,0,0,1,212,96Zm-84,57V88a8,8,0,0,0-16,0v65a32,32,0,1,0,16,0Zm-8,47a16,16,0,1,1,16-16A16,16,0,0,1,120,200Zm40-66V48a40,40,0,0,0-80,0v86a64,64,0,1,0,80,0Zm-40,98a48,48,0,0,1-27.42-87.4A8,8,0,0,0,96,138V48a24,24,0,0,1,48,0v90a8,8,0,0,0,3.42,6.56A48,48,0,0,1,120,232Z"></path>
              </svg>
            </div>
            <div class="flex flex-col gap-1">
              <h2 class="text-white text-base font-bold leading-tight">Control de Clima</h2>
              <p class="text-[#a0adbb] text-sm font-normal leading-normal">Mantén la temperatura perfecta con termostatos inteligentes y control de clima automatizado.</p>
            </div>
          </div>
          <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
            <div class="text-white" data-icon="Camera" data-size="24px" data-weight="regular">
              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                <path
                  d="M208,56H180.28L166.65,35.56A8,8,0,0,0,160,32H96a8,8,0,0,0-6.65,3.56L75.71,56H48A24,24,0,0,0,24,80V192a24,24,0,0,0,24,24H208a24,24,0,0,0,24-24V80A24,24,0,0,0,208,56Zm8,136a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V80a8,8,0,0,1,8-8H80a8,8,0,0,0,6.66-3.56L100.28,48h55.43l13.63,20.44A8,8,0,0,0,176,72h32a8,8,0,0,1,8,8ZM128,88a44,44,0,1,0,44,44A44.05,44.05,0,0,0,128,88Zm0,72a28,28,0,1,1,28-28A28,28,0,0,1,128,160Z"></path>
              </svg>
            </div>
            <div class="flex flex-col gap-1">
              <h2 class="text-white text-base font-bold leading-tight">Vigilancia</h2>
              <p class="text-[#a0adbb] text-sm font-normal leading-normal">Vigila tu propiedad con cámaras de alta definición y acceso remoto.</p>
            </div>
          </div>
          <div class="flex flex-1 gap-3 rounded-lg border border-[#3f4d5a] bg-[#20262d] p-4 flex-col">
            <div class="text-white" data-icon="MusicNote" data-size="24px" data-weight="regular">
              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                <path
                  d="M210.3,56.34l-80-24A8,8,0,0,0,120,40V148.26A48,48,0,1,0,136,184V98.75l69.7,20.91A8,8,0,0,0,216,112V64A8,8,0,0,0,210.3,56.34ZM88,216a32,32,0,1,1,32-32A32,32,0,0,1,88,216ZM200,101.25l-64-19.2V50.75L200,70Z"></path>
              </svg>
            </div>
            <div class="flex flex-col gap-1">
              <h2 class="text-white text-base font-bold leading-tight">Entretenimiento</h2>
              <p class="text-[#a0adbb] text-sm font-normal leading-normal">Disfruta de integración perfecta con tus sistemas de música y entretenimiento favoritos.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="section4" class="section space-y-4">
      <h2 id="how-it-works" class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 scroll-mt-20">¿Cómo Funciona?</h2>
      <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
        DomoticLink se integra con los sistemas existentes de tu hogar para crear una experiencia de hogar inteligente unificada. Nuestro sistema utiliza un centro de control para conectar todos tus dispositivos, permitiéndote controlarlos desde una sola aplicación. Con funciones avanzadas de automatización, tu hogar aprende tus preferencias y ajusta la configuración automáticamente, ahorrándote tiempo y ofreciendo la máxima comodidad.
      </p>
    </section>

    <section id="section5" class="section space-y-4">
      <h2 class="text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3">Descargar App</h2>
      <p class="text-base font-normal leading-normal pb-6 px-4">
        Descarga nuestra aplicación para controlar tu hogar inteligente desde cualquier lugar. Disponible para iOS y Android.
      </p>
      <div class="flex flex-col md:flex-row gap-4 px-4">
        <a href="#" class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.53 4.08zM12 6.8c0-1.4 1.15-2.64 2.1-3.7-.33-2.24-2.21-3.02-2.1-3.7C10.1.1 9.31 2.3 11.34 4.1c.75.64 1.66 1.03 2.66 1.14-.02-.16.01-.3 0-.44z"></path>
          </svg>
          <div class="text-left">
            <div class="text-xs">Descargar en la</div>
            <div class="text-xl font-semibold">App Store</div>
          </div>
        </a>
        <a href="#" class="flex items-center justify-center gap-2 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3.609 1.814L13.792 12 3.61 22.186a.996.996 0 0 1-.61-.92v-18.53a1 1 0 0 1 .609-.922zm.921 2.387L11 11.955 4.53 19.673 4.53 4.201zM14.043 12l4.174 4.174-2.704 2.705-4.175-4.175 2.705-2.704zM19.5 14.573l-2.75-2.75 2.75-2.75.002 5.5z"></path>
          </svg>
          <div class="text-left">
            <div class="text-xs">Obtén en</div>
            <div class="text-xl font-semibold">Google Play</div>
          </div>
        </a>
      </div>
    </section>

    <!-- Panel de Control Domótico -->
    <section id="control-panel" class="section space-y-4 scroll-mt-20">
      <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Panel de Control</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 px-4">
        <!-- Control de Puerta -->
        <div class="control-card">
          <h3 class="font-bold text-lg">Puerta Principal</h3>
          <button onclick="toggleDevice('puerta', this)" class="control-button">Alternar</button>
        </div>
        <!-- Control de Garaje -->
        <div class="control-card">
          <h3 class="font-bold text-lg">Garaje</h3>
          <button onclick="toggleDevice('garaje', this)" class="control-button">Alternar</button>
        </div>
        <!-- Control de Luces -->
        <div class="control-card">
          <h3 class="font-bold text-lg">Luces Global</h3>
          <button onclick="toggleDevice('todo', this)" class="control-button">Alternar</button>
        </div>
        <!-- Control de Extractor -->
        <div class="control-card">
          <h3 class="font-bold text-lg">Extractor</h3>
          <button onclick="toggleDevice('extractor', this)" class="control-button">Alternar</button>
        </div>
      </div>
    </section>

    <!-- Sección de Tour Virtual -->
    <section id="virtual-tour" class="virtual-tour-section scroll-mt-20">
      <div id="tour-initial-content">
        <h2 class="text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3">Tour Virtual</h2>
        <p class="text-base font-normal leading-normal pb-6 px-4">
          Explora una casa inteligente con nuestro tour virtual interactivo. Descubre cómo la tecnología puede transformar tu hogar.
        </p>
        <div class="relative overflow-hidden rounded-xl mx-4 aspect-video md:aspect-video bg-gray-800 flex items-center justify-center" style="min-height: 300px;">
          <div class="text-center p-8">
            <svg class="w-16 h-16 mx-auto text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-bold text-white mb-2">Tour Virtual Interactivo</h3>
            <p class="text-gray-300 mb-4">Haz clic en el botón para comenzar la experiencia inmersiva</p>
            <button id="start-tour-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition-colors">
              Iniciar Tour
            </button>
          </div>
        </div>
      </div>
      <div id="tour-iframe-container" class="hidden relative mx-4 aspect-video rounded-xl overflow-hidden">
        <button id="close-tour-btn" class="absolute top-4 right-4 z-10 bg-gray-900 bg-opacity-80 text-white rounded-full px-3 py-1 font-bold hover:bg-opacity-100">Cerrar</button>
        <iframe src="/casa-de-infonavit/public/utils/tourvirtual.html" class="w-full h-full min-h-[400px] rounded-xl border-0" allowfullscreen></iframe>
      </div>
    </section>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var startBtn = document.getElementById('start-tour-btn');
        var closeBtn = document.getElementById('close-tour-btn');
        var initialContent = document.getElementById('tour-initial-content');
        var iframeContainer = document.getElementById('tour-iframe-container');
        if (startBtn) {
          startBtn.addEventListener('click', function() {
            initialContent.style.display = 'none';
            iframeContainer.classList.remove('hidden');
          });
        }
        if (closeBtn) {
          closeBtn.addEventListener('click', function() {
            iframeContainer.classList.add('hidden');
            initialContent.style.display = '';
          });
        }
      });
    </script>
    <section id="team" class="py-16 px-4 sm:px-6 lg:px-8" x-data="teamCarousel">
      <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-white mb-12">Nuestro Equipo</h2>

        <!-- Carrusel -->
        <div class="relative">
          <div class="swiper team-swiper">
            <div class="swiper-wrapper pb-10">
              <template x-for="(member, index) in teamMembers" :key="index">
                <div class="swiper-slide">
                  <div @click="openModal(member)" class="bg-[#20262d] rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:scale-105 cursor-pointer mx-2">
                    <div class="h-64 bg-gray-700 flex items-center justify-center">
                      <img :src="member.image" :alt="member.name" class="h-full w-full object-cover">
                    </div>
                    <div class="p-6">
                      <h3 class="text-xl font-semibold text-white" x-text="member.name"></h3>
                      <p class="text-blue-300 mb-2" x-text="member.position"></p>
                      <p class="text-gray-400 text-sm" x-text="member.shortBio"></p>
                    </div>
                  </div>
                </div>
              </template>
            </div>
            <!-- Navegación -->
            <div class="swiper-button-next text-blue-400"></div>
            <div class="swiper-button-prev text-blue-400"></div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>

      <!-- Modal Simple -->
      <div x-show="isOpen"
        x-cloak
        @click.self="closeModal()"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-70">
        <div class="bg-[#20262d] rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
          <div class="p-6">
            <!-- Encabezado -->
            <div class="flex justify-between items-start mb-6">
              <h3 class="text-2xl font-bold text-white" x-text="selectedMember.name"></h3>
              <button @click="closeModal()" class="text-gray-400 hover:text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Contenido -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <!-- Columna izquierda: Foto e info básica -->
              <div class="space-y-4">
                <img :src="selectedMember.image" :alt="selectedMember.name" class="w-full h-64 object-cover rounded-lg">
                <div>
                  <h4 class="text-lg font-semibold text-blue-300" x-text="selectedMember.position"></h4>
                  <p class="text-gray-400 text-sm mt-1" x-text="selectedMember.email"></p>
                  <p class="text-gray-400 text-sm mt-1" x-text="selectedMember.phone"></p>
                </div>
              </div>

              <!-- Columna derecha: Detalles -->
              <div class="md:col-span-2 space-y-6">
                <!-- Biografía -->
                <div>
                  <h4 class="text-lg font-semibold text-white mb-2">Biografía</h4>
                  <p class="text-gray-300" x-text="selectedMember.bio"></p>
                </div>

                <!-- Habilidades -->
                <div>
                  <h4 class="text-lg font-semibold text-white mb-2">Habilidades</h4>
                  <div class="flex flex-wrap gap-2">
                    <template x-for="(skill, index) in selectedMember.skills" :key="index">
                      <span class="bg-blue-900 text-blue-100 text-xs px-3 py-1 rounded-full" x-text="skill"></span>
                    </template>
                  </div>
                </div>

                <!-- Experiencia -->
                <div>
                  <h4 class="text-lg font-semibold text-white mb-3">Experiencia</h4>
                  <div class="space-y-4">
                    <template x-for="(exp, index) in selectedMember.experience" :key="index">
                      <div class="border-l-2 border-blue-500 pl-4 py-1">
                        <h5 class="text-white font-medium" x-text="exp.role"></h5>
                        <p class="text-blue-300 text-sm" x-text="exp.company"></p>
                        <p class="text-gray-400 text-xs" x-text="exp.duration"></p>
                      </div>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>
      document.addEventListener('alpine:init', () => {
        Alpine.data('teamCarousel', () => ({
          isOpen: false,
          selectedMember: {
            name: '',
            position: '',
            email: '',
            phone: '',
            bio: '',
            skills: [],
            experience: []
          },
          teamMembers: [{
              name: 'Dara',
              position: 'Líder del Equipo',
              email: 'dara@example.com',
              phone: '+52 55 1111 2222',
              image: 'public/image/ourt/dara.jpg',
              shortBio: 'Líder y visionaria del proyecto.',
              bio: 'Dara es la fuerza impulsora detrás de la visión del equipo, combinando liderazgo con una profunda experiencia técnica para guiar al equipo hacia el éxito.',
              skills: ['Liderazgo', 'Gestión de Proyectos', 'Arquitectura de Software'],
              experience: [{
                role: 'Líder de Proyecto',
                company: 'Innovatech',
                duration: '2020 - Presente'
              }]
            },
            {
              name: 'Edwin',
              position: 'Desarrollador Backend',
              email: 'edwin@example.com',
              phone: '+52 55 3333 4444',
              image: 'public/image/ourt/edwin.jpg',
              shortBio: 'El arquitecto de nuestra infraestructura.',
              bio: 'Edwin se especializa en la construcción de sistemas robustos y escalables, asegurando que toda la lógica del servidor funcione a la perfección.',
              skills: ['Node.js', 'Bases de Datos', 'API REST', 'Microservicios'],
              experience: [{
                role: 'Ingeniero Backend',
                company: 'Data Systems',
                duration: '2019 - Presente'
              }]
            },
            {
              name: 'Jocabed',
              position: 'Diseñadora UX/UI',
              email: 'jocabed@example.com',
              phone: '+52 55 5555 6666',
              image: 'public/image/ourt/jocabed.jpg',
              shortBio: 'Creadora de experiencias de usuario.',
              bio: 'Jocabed diseña interfaces intuitivas y atractivas, enfocándose en que la interacción del usuario con la tecnología sea simple y agradable.',
              skills: ['Diseño UX/UI', 'Prototipado', 'Figma', 'Adobe XD'],
              experience: [{
                role: 'Diseñadora UX/UI',
                company: 'Creative Minds',
                duration: '2021 - Presente'
              }]
            },
            {
              name: 'Jona',
              position: 'Desarrollador Frontend',
              email: 'jona@example.com',
              phone: '+52 55 7777 8888',
              image: 'public/image/ourt/jona.jpg',
              shortBio: 'El mago de la interfaz de usuario.',
              bio: 'Jona transforma los diseños en realidad, escribiendo código limpio y eficiente para crear interfaces de usuario dinámicas y responsivas.',
              skills: ['JavaScript', 'React', 'Vue.js', 'CSS Moderno'],
              experience: [{
                role: 'Desarrollador Frontend',
                company: 'Web Solutions',
                duration: '2018 - Presente'
              }]
            },
            {
              name: 'Laura',
              position: 'Especialista en QA',
              email: 'laura@example.com',
              phone: '+52 55 9999 0000',
              image: 'public/image/ourt/laura.jpg',
              shortBio: 'Garantiza la calidad de nuestro software.',
              bio: 'Laura es meticulosa en la detección de errores, asegurando que cada producto que lanzamos cumpla con los más altos estándares de calidad.',
              skills: ['Testing Manual', 'Automatización de Pruebas', 'Selenium', 'Jira'],
              experience: [{
                role: 'Ingeniera de Calidad',
                company: 'Tech Labs',
                duration: '2019 - Presente'
              }]
            },
            {
              name: 'Manny',
              position: 'Experto en Domótica',
              email: 'manny@example.com',
              phone: '+52 55 1234 5678',
              image: 'public/image/ourt/manny.jpg',
              shortBio: 'El cerebro detrás de la casa inteligente.',
              bio: 'Manny es el especialista en hardware y automatización del hogar, conectando el mundo físico con el digital para crear una experiencia de hogar inteligente y cohesiva.',
              skills: ['Arduino', 'ESP32', 'IoT', 'Integración de Hardware'],
              experience: [{
                role: 'Especialista en IoT',
                company: 'Smart Homes Inc.',
                duration: '2017 - Presente'
              }]
            }
          ],
          openModal(member) {
            if (member) {
              this.selectedMember = {
                ...member
              };
              this.isOpen = true;
              document.body.style.overflow = 'hidden';
            }
          },
          closeModal() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
          },
          init() {
            // Inicializar Swiper
            this.$nextTick(() => {
              const swiper = new Swiper('.team-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                  delay: 5000,
                  disableOnInteraction: false,
                },
                pagination: {
                  el: '.swiper-pagination',
                  clickable: true,
                },
                breakpoints: {
                  640: {
                    slidesPerView: 2,
                  },
                  1024: {
                    slidesPerView: 3,
                  },
                },
              });
            });
          }
        }));
      });
    </script>
    <section id="contact" class="section space-y-4 pb-24">
      <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Tour Virtual</h2>
      <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">
        Explora una casa inteligente con nuestro tour virtual interactivo. Descubre cómo la tecnología puede transformar tu hogar.
      </p>
      <h2 class="text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Contacto</h2>
      <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
        <label class="flex flex-col min-w-40 flex-1">
          <input
            placeholder="Tu Nombre"
            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none h-14 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
            value="" />
        </label>
      </div>
      <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
        <label class="flex flex-col min-w-40 flex-1">
          <input
            placeholder="Tu Correo Electrónico"
            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none h-14 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"
            value="" />
        </label>
      </div>
      <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
        <label class="flex flex-col min-w-40 flex-1">
          <textarea
            placeholder="Tu Mensaje"
            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border-none bg-[#2c363f] focus:border-none min-h-36 placeholder:text-[#a0adbb] p-4 text-base font-normal leading-normal"></textarea>
        </label>
      </div>
      <div class="flex px-4 py-3 justify-start">
        <button
          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#dae5f0] text-[#151a1e] text-sm font-bold leading-normal tracking-[0.015em]">
          <span class="truncate">Enviar</span>
        </button>
      </div>

    </section>

  </main>

  <!-- Footer -->
  <footer class="flex justify-center">
    <div class="flex max-w-[960px] flex-1 flex-col">
      <footer class="flex flex-col gap-6 px-5 py-10 text-center @container">
        <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
          <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Política de Privacidad</a>
          <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Términos de Servicio</a>
          <a class="text-[#a0adbb] text-base font-normal leading-normal min-w-40" href="#">Contáctanos</a>
        </div>
        <div class="flex justify-center">
          <div class="h-16 w-16">
            <img src="public/image/logo.png" alt="Logo DomoticLink" class="h-full w-full object-contain">
          </div>
        </div>
        <p class="text-[#a0adbb] text-base font-normal leading-normal"> 2024 DomoticLink. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Alpine.js y plugins -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
  <!-- scripts.js mantiene la interactividad 3D y scroll -->
  <script type="module" src="public/a.js"></script>
  <script type="module" src="public/js/mein.js"></script>

  <!-- Botones Flotantes -->
  <a href="https://wa.me/5211234567890?text=Hola,%20estoy%20interesado%20en%20sus%20servicios." target="_blank" class="whatsapp-btn" title="Contactar por WhatsApp">
    <i class="fab fa-whatsapp"></i>
  </a>
  <button id="toggle-particles-btn" title="Activar/Desactivar Partículas">
    <i class="fas fa-atom"></i>
  </button>

  <style>
    .whatsapp-btn,
    #toggle-particles-btn {
      position: fixed;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 28px;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.2s, box-shadow 0.2s;
      z-index: 1000;
    }

    .whatsapp-btn:hover,
    #toggle-particles-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    .whatsapp-btn {
      background-color: #25D366;
      /* Verde de WhatsApp */
      bottom: 20px;
      right: 20px;
    }

    #toggle-particles-btn {
      background-color: #007bff;
      /* Azul */
      bottom: 20px;
      left: 20px;
    }

    #toggle-particles-btn.off {
      background-color: #6c757d;
      /* Gris */
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('toggle-particles-btn');
      const particlesContainer = document.getElementById('particles-js');

      // Estado inicial de las partículas (activadas por defecto)
      let particlesEnabled = true;

      toggleBtn.addEventListener('click', () => {
        if (particlesEnabled) {
          particlesContainer.style.display = 'none';
          toggleBtn.classList.add('off');
        } else {
          particlesContainer.style.display = 'block';
          toggleBtn.classList.remove('off');
        }
        particlesEnabled = !particlesEnabled;
      });
    });
  </script>

  <!-- Script para el Preloader -->
  <script>
    window.addEventListener('load', function() {
      const preloader = document.getElementById('preloader');
      preloader.classList.add('hidden');
    });
  </script>

  <!-- Script para Panel de Control -->
  <script>
    const esp32_ip = '192.168.1.100'; // <-- IMPORTANTE: Reemplaza con la IP de tu ESP32

    // Estado inicial de los dispositivos (false = apagado/cerrado)
    const deviceStatus = {
      puerta: false,
      garaje: false,
      todo: false, // Para luces globales
      extractor: false
    };

    function toggleDevice(deviceName, button) {
      // Alternar el estado
      deviceStatus[deviceName] = !deviceStatus[deviceName];
      const isActive = deviceStatus[deviceName];

      let command_on, command_off;

      switch (deviceName) {
        case 'puerta':
          command_on = 'abrir_puerta';
          command_off = 'cerrar_puerta';
          break;
        case 'garaje':
          command_on = 'abrir_garaje';
          command_off = 'cerrar_garaje';
          break;
        case 'todo':
          command_on = 'encender_todo';
          command_off = 'apagar_todo';
          break;
        case 'extractor':
          command_on = 'iniciar_extractor';
          command_off = 'detener_extractor';
          break;
      }

      const command = isActive ? command_on : command_off;

      fetch(`http://${esp32_ip}/${command}`)
        .then(response => response.text())
        .then(data => {
          console.log(data);
          // Actualizar el estilo del botón
          if (isActive) {
            button.classList.add('active');
          } else {
            button.classList.remove('active');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('No se pudo conectar con la casa. Verifica la IP y la conexión.');
          // Revertir el estado si falla la comunicación
          deviceStatus[deviceName] = !isActive;
        });
    }
  </script>

  <!-- Dark Mode Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const darkModeToggle = document.getElementById('darkModeToggle');
      const body = document.body;

      // Función para aplicar el tema
      const applyTheme = (isDark) => {
        if (isDark) {
          body.classList.add('dark');
          darkModeToggle.checked = true;
        } else {
          body.classList.remove('dark');
          darkModeToggle.checked = false;
        }
      };

      // Comprobar preferencia guardada en localStorage
      const savedTheme = localStorage.getItem('darkMode');
      if (savedTheme) {
        applyTheme(savedTheme === 'true');
      } else {
        // Opcional: detectar preferencia del sistema operativo
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDark);
      }

      // Event listener para el botón
      darkModeToggle.addEventListener('change', function() {
        const isDark = this.checked;
        applyTheme(isDark);
        localStorage.setItem('darkMode', isDark);
      });
    });
  </script>
</body>

</html>