// Usar THREE global en lugar de importaciones de módulos
const { GLTFLoader } = THREE;

// Variables globales
let scene, camera, renderer, model, mixer;

// Inicialización de la escena
function init() {
    // Verificar si el contenedor existe
    const container = document.getElementById('model-container');
    if (!container) {
        console.error('No se encontró el contenedor del modelo');
        return;
    }

    // Crear escena
    scene = new THREE.Scene();
    
    // Configurar cámara
    camera = new THREE.PerspectiveCamera(
        10, // FOV más pequeño para un efecto más cercano
        window.innerWidth / window.innerHeight,
        0.1,
        1000
    );
    camera.position.z = 13;
    
    // Configurar renderizador
    renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true // Fondo transparente
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    
    // Limpiar cualquier canvas existente
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }
    container.appendChild(renderer.domElement);
    
    // Configurar luces
    const ambientLight = new THREE.AmbientLight(0xffffff, 1.3);
    scene.add(ambientLight);
    
    const topLight = new THREE.DirectionalLight(0xffffff, 1);
    topLight.position.set(500, 500, 500);
    scene.add(topLight);
    
    // Cargar modelo
    loadModel();
    
    // Manejar redimensionamiento
    window.addEventListener('resize', onWindowResize);
    
    // Iniciar animación
    animate();
}

// Cargar modelo 3D
function loadModel() {
    const loader = new GLTFLoader();
    
    // Ruta al modelo GLB/GLTF - Ruta relativa desde la raíz del sitio web
    const modelPath = '/model/logo.glb';
    
    loader.load(
        modelPath,
        function (gltf) {
            model = gltf.scene;
            scene.add(model);
            
            // Configurar animaciones si existen
            if (gltf.animations && gltf.animations.length > 0) {
                mixer = new THREE.AnimationMixer(model);
                const action = mixer.clipAction(gltf.animations[0]);
                action.play();
            }
            
            // Ajustar posición inicial del modelo
            if (model) {
                model.position.set(0, 0, 0);
                model.rotation.set(0, 0, 0);
                model.scale.set(1, 1, 1);
            }
            
            // Iniciar seguimiento de scroll
            setupScrollAnimation();
        },
        // Función de progreso
        function (xhr) {
            console.log((xhr.loaded / xhr.total) * 100 + '% cargado');
        },
        // Función de error
        function (error) {
            console.error('Error al cargar el modelo:', error);
        }
    );
}

// Configurar animación basada en scroll
function setupScrollAnimation() {
    // Posiciones predefinidas para diferentes secciones
    const sections = [
        { id: 'inicio', position: { x: 0, y: 0, z: 0 }, rotation: { x: 0, y: 0, z: 0 } },
        { id: 'como-funciona', position: { x: 1.4, y: 0, z: 0 }, rotation: { x: 0, y: 1, z: 0 } },
        { id: 'beneficios', position: { x: -1.8, y: 0, z: 0 }, rotation: { x: 0, y: -1.5, z: 0 } },
        { id: 'testimonios', position: { x: 1.5, y: 0, z: 0 }, rotation: { x: 0, y: 1.5, z: 0 } },
        { id: 'contacto', position: { x: 0, y: 0, z: 0 }, rotation: { x: 0, y: 0, z: 0 } }
    ];
    
    // Función para actualizar la posición del modelo según el scroll
    function updateModelPosition() {
        if (!model) return;
        
        const scrollPosition = window.scrollY;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight - windowHeight;
        const scrollProgress = Math.min(scrollPosition / documentHeight, 1);
        
        // Calcular la sección actual basada en el progreso del scroll
        const sectionIndex = Math.min(
            Math.floor(scrollProgress * sections.length),
            sections.length - 1
        );
        
        const currentSection = sections[sectionIndex];
        
        // Aplicar animación suave a la posición y rotación
        gsap.to(model.position, {
            x: currentSection.position.x,
            y: currentSection.position.y,
            z: currentSection.position.z,
            duration: 1.5,
            ease: 'power2.out'
        });
        
        gsap.to(model.rotation, {
            x: currentSection.rotation.x,
            y: currentSection.rotation.y,
            z: currentSection.rotation.z,
            duration: 1.5,
            ease: 'power2.out'
        });
    }
    
    // Escuchar eventos de scroll
    window.addEventListener('scroll', updateModelPosition);
    
    // Actualizar posición inicial
    updateModelPosition();
}

// Manejar redimensionamiento de la ventana
function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
    
    // Ajustar el tamaño del canvas
    const container = document.getElementById('model-container');
    if (container) {
        renderer.setSize(container.offsetWidth, container.offsetHeight);
    }
}

// Bucle de animación
function animate() {
    requestAnimationFrame(animate);
    
    // Rotación continua del modelo
    if (model) {
        model.rotation.y += 0.002; // Rotación más lenta
    }
    
    // Actualizar animaciones
    if (mixer) {
        mixer.update(0.01);
    }
    
    // Renderizar escena
    renderer.render(scene, camera);
}

// Iniciar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    // DOM ya está listo
    init();
}

// Manejar errores de carga del modelo
window.addEventListener('error', (error) => {
    console.error('Error en el renderizado 3D:', error);
});

// Manejar redimensionamiento de la ventana
window.addEventListener('resize', onWindowResize);
