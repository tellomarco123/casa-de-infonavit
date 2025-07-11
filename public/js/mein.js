  // Función para alternar el menú móvil
    function toggleMobileMenu() {
      const mobileMenu = document.getElementById('mobile-menu');
      const menuButton = document.getElementById('menu-button');
      const isOpen = mobileMenu.classList.contains('hidden');

      if (isOpen) {
        mobileMenu.classList.remove('hidden');
        menuButton.classList.add('open');
        document.body.style.overflow = 'hidden';
      } else {
        mobileMenu.classList.add('hidden');
        menuButton.classList.remove('open');
        document.body.style.overflow = 'auto';
      }
    }

    // Cerrar menú al hacer clic en un enlace
    function closeMobileMenu() {
      const mobileMenu = document.getElementById('mobile-menu');
      const menuButton = document.getElementById('menu-button');
      mobileMenu.classList.add('hidden');
      menuButton.classList.remove('open');
      document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Verificar preferencia de tema
      if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        if (document.getElementById('darkModeToggle')) {
          document.getElementById('darkModeToggle').checked = true;
        }
      } else {
        document.documentElement.classList.remove('dark');
      }

      // Smooth scroll para enlaces internos
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('href');
          if (targetId === '#') return;

          const targetElement = document.querySelector(targetId);
          if (targetElement) {
            targetElement.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });

            // Cerrar menú móvil si está abierto
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('menu-button');
            if (!mobileMenu.classList.contains('hidden')) {
              mobileMenu.classList.add('hidden');
              menuButton.classList.remove('open');
            }
          }
        });
      });

      // Toggle menú móvil
      const menuButton = document.getElementById('menu-button');
      const mobileMenu = document.getElementById('mobile-menu');

      if (menuButton) {
        // Manejar clic en el botón del menú
        menuButton.addEventListener('click', function(e) {
          e.stopPropagation();
          toggleMobileMenu();
        });

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(e) {
          if (!mobileMenu.contains(e.target) && !menuButton.contains(e.target)) {
            closeMobileMenu();
          }
        });

        // Cerrar menú al hacer scroll
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
          const st = window.pageYOffset || document.documentElement.scrollTop;
          if (Math.abs(st - lastScrollTop) > 10) { // Solo si el desplazamiento es significativo
            closeMobileMenu();
          }
          lastScrollTop = st <= 0 ? 0 : st;
        });
      }

      // Cerrar menú al hacer clic fuera
      document.addEventListener('click', function(e) {
        if (!menuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
          menuButton.classList.remove('open');
          mobileMenu.classList.add('hidden');
        }
      });

      // Toggle modo oscuro
      const darkModeToggle = document.getElementById('darkModeToggle');
      if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
          if (this.checked) {
            localStorage.theme = 'dark';
            document.documentElement.classList.add('dark');
          } else {
            localStorage.theme = 'light';
            document.documentElement.classList.remove('dark');
          }
        });
      }

      // Mostrar/ocultar modal de contacto
      const contactButtons = document.querySelectorAll('[data-modal-toggle="contactModal"]');
      const contactModal = document.getElementById('contactModal');
      const closeButtons = document.querySelectorAll('[data-modal-hide="contactModal"]');

      contactButtons.forEach(button => {
        button.addEventListener('click', () => {
          contactModal.classList.remove('hidden');
          document.body.style.overflow = 'hidden';
        });
      });

      closeButtons.forEach(button => {
        button.addEventListener('click', () => {
          contactModal.classList.add('hidden');
          document.body.style.overflow = 'auto';
        });
      });

      // Cerrar modal al hacer clic fuera del contenido
      contactModal.addEventListener('click', (e) => {
        if (e.target === contactModal) {
          contactModal.classList.add('hidden');
          document.body.style.overflow = 'auto';
        }
      });
    });
    // Configuración de partículas
    document.addEventListener('DOMContentLoaded', function() {
      particlesJS('particles-js', {
        "particles": {
          "number": {
            "value": 380,
            "density": {
              "enable": true,
              "value_area": 800
            }
          },
          "color": {
            "value": "#ffffff"
          },
          "shape": {
            "type": "circle",
            "stroke": {
              "width": 0,
              "color": "#000000"
            },
            "polygon": {
              "nb_sides": 5
            }
          },
          "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
              "enable": false,
              "speed": 1,
              "opacity_min": 0.1,
              "sync": false
            }
          },
          "size": {
            "value": 3,
            "random": true,
            "anim": {
              "enable": false,
              "speed": 40,
              "size_min": 0.1,
              "sync": false
            }
          },
          "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
              "enable": false,
              "rotateX": 600,
              "rotateY": 1200
            }
          }
        },
        "interactivity": {
          "detect_on": "window",
          "events": {
            "onhover": {
              "enable": true,
              "mode": "grab"
            },
            "onclick": {
              "enable": true,
              "mode": "push"
            },
            "resize": true
          },
          "modes": {
            "grab": {
              "distance": 200,
              "line_linked": {
                "opacity": 0.8
              }
            },
            "bubble": {
              "distance": 250,
              "size": 10,
              "duration": 0.5,
              "opacity": 0.8,
              "speed": 3
            },
            "repulse": {
              "distance": 150,
              "duration": 0.4
            },
            "push": {
              "particles_nb": 8
            },
            "remove": {
              "particles_nb": 2
            },
            "attract": {
              "enable": true,
              "rotateX": 1000,
              "rotateY": 1200
            }
          }
        },
        "retina_detect": true
      });
    });